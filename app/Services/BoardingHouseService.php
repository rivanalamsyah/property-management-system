<?php

namespace App\Services;

use App\Models\BoardingHouse;
use App\Models\BoardingHouseGallery;
use App\Models\BoardingHouseRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BoardingHouseService
{
    public function createBoardingHouse(array $data): BoardingHouse
    {
        return DB::transaction(function () use ($data) {
            $slug = Str::slug($data['name']);
            $originalSlug = $slug;
            $count = 1;
            
            while (BoardingHouse::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $data['slug'] = $slug;
            $data['settings'] = BoardingHouse::defaultSettings();

            $boardingHouse = BoardingHouse::create($data);

            activity_log(
                event: 'boarding_house.create',
                description: "Created new boarding house: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );

            return $boardingHouse;
        });
    }

    public function updateBoardingHouse(BoardingHouse $boardingHouse, array $data): BoardingHouse
    {
        return DB::transaction(function () use ($boardingHouse, $data) {
            if (isset($data['name']) && $data['name'] !== $boardingHouse->name) {
                $slug = Str::slug($data['name']);
                $originalSlug = $slug;
                $count = 1;
                while (BoardingHouse::where('slug', $slug)->where('id', '!=', $boardingHouse->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                $data['slug'] = $slug;
            }

            $boardingHouse->update($data);

            activity_log(
                event: 'boarding_house.update',
                description: "Updated profile details for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );

            return $boardingHouse;
        });
    }

    public function deleteBoardingHouse(BoardingHouse $boardingHouse): void
    {
        DB::transaction(function () use ($boardingHouse) {
            // Delete all associated files
            if ($boardingHouse->logo) {
                Storage::disk('public')->delete($boardingHouse->logo);
            }
            if ($boardingHouse->cover_image) {
                Storage::disk('public')->delete($boardingHouse->cover_image);
            }

            foreach ($boardingHouse->galleries as $gallery) {
                Storage::disk('public')->delete($gallery->file_path);
            }

            $name = $boardingHouse->name;
            $tenantId = $boardingHouse->tenant_id;
            $boardingHouse->delete();

            activity_log(
                event: 'boarding_house.delete',
                description: "Deleted boarding house: {$name}",
                tenantId: $tenantId
            );
        });
    }

    public function updateSettings(BoardingHouse $boardingHouse, array $settings): void
    {
        DB::transaction(function () use ($boardingHouse, $settings) {
            // Merge settings
            $currentSettings = $boardingHouse->settings ?? [];
            $newSettings = array_merge(BoardingHouse::defaultSettings(), $currentSettings, $settings);
            
            $boardingHouse->update(['settings' => $newSettings]);

            activity_log(
                event: 'boarding_house.settings_update',
                description: "Updated settings config for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );
        });
    }

    public function syncFacilities(BoardingHouse $boardingHouse, array $facilitiesData): void
    {
        // $facilitiesData format: [facility_id => ['is_featured' => boolean]]
        DB::transaction(function () use ($boardingHouse, $facilitiesData) {
            $boardingHouse->facilities()->sync($facilitiesData);

            activity_log(
                event: 'boarding_house.facilities_sync',
                description: "Synchronized facilities list for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );
        });
    }

    public function addGalleryImage(BoardingHouse $boardingHouse, string $filePath, bool $isCover = false, ?string $label = null): BoardingHouseGallery
    {
        return DB::transaction(function () use ($boardingHouse, $filePath, $isCover, $label) {
            if ($isCover) {
                $boardingHouse->galleries()->update(['is_cover' => false]);
            }

            $maxOrder = $boardingHouse->galleries()->max('display_order') ?? 0;

            $gallery = $boardingHouse->galleries()->create([
                'file_path' => $filePath,
                'is_cover' => $isCover,
                'display_order' => $maxOrder + 1,
                'label' => $label,
            ]);

            activity_log(
                event: 'boarding_house.gallery_upload',
                description: "Uploaded new image to gallery for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );

            return $gallery;
        });
    }

    public function removeGalleryImage(BoardingHouseGallery $gallery): void
    {
        DB::transaction(function () use ($gallery) {
            Storage::disk('public')->delete($gallery->file_path);
            $boardingHouse = $gallery->boardingHouse;
            $gallery->delete();

            activity_log(
                event: 'boarding_house.gallery_delete',
                description: "Deleted image from gallery for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );
        });
    }

    public function setCoverImage(BoardingHouseGallery $gallery): void
    {
        DB::transaction(function () use ($gallery) {
            $boardingHouse = $gallery->boardingHouse;
            $boardingHouse->galleries()->update(['is_cover' => false]);
            $gallery->update(['is_cover' => true]);

            // Update main cover_image field too as fallback
            $boardingHouse->update(['cover_image' => $gallery->file_path]);

            activity_log(
                event: 'boarding_house.gallery_set_cover',
                description: "Updated cover image for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );
        });
    }

    public function syncGalleryOrder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                BoardingHouseGallery::where('id', $id)->update(['display_order' => $index]);
            }
        });
    }

    public function addRule(BoardingHouse $boardingHouse, array $data): BoardingHouseRule
    {
        return DB::transaction(function () use ($boardingHouse, $data) {
            $maxOrder = $boardingHouse->rules()->max('display_order') ?? 0;
            $data['display_order'] = $maxOrder + 1;

            $rule = $boardingHouse->rules()->create($data);

            activity_log(
                event: 'boarding_house.rule_add',
                description: "Added house rule '{$rule->title}' for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );

            return $rule;
        });
    }

    public function updateRule(BoardingHouseRule $rule, array $data): BoardingHouseRule
    {
        return DB::transaction(function () use ($rule, $data) {
            $rule->update($data);

            activity_log(
                event: 'boarding_house.rule_update',
                description: "Updated house rule '{$rule->title}' for: {$rule->boardingHouse->name}",
                tenantId: $rule->boardingHouse->tenant_id
            );

            return $rule;
        });
    }

    public function removeRule(BoardingHouseRule $rule): void
    {
        DB::transaction(function () use ($rule) {
            $title = $rule->title;
            $boardingHouse = $rule->boardingHouse;
            $rule->delete();

            activity_log(
                event: 'boarding_house.rule_delete',
                description: "Deleted house rule '{$title}' for: {$boardingHouse->name}",
                tenantId: $boardingHouse->tenant_id
            );
        });
    }

    public function syncRulesOrder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                BoardingHouseRule::where('id', $id)->update(['display_order' => $index]);
            }
        });
    }
}
