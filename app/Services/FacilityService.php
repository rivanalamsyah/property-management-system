<?php

namespace App\Services;

use App\Models\Facility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FacilityService
{
    public function createFacility(array $data): Facility
    {
        return DB::transaction(function () use ($data) {
            $slug = Str::slug($data['name']);
            $originalSlug = $slug;
            $count = 1;
            
            // Query using current tenant filter
            $query = Facility::query();
            if (function_exists('tenant') && tenant()) {
                $query->where('tenant_id', tenant()->id);
            } else {
                $query->whereNull('tenant_id');
            }

            while ((clone $query)->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $data['slug'] = $slug;
            $maxOrder = Facility::forCurrentTenant()->max('display_order') ?? 0;
            $data['display_order'] = $maxOrder + 1;

            if (empty($data['tenant_id']) && function_exists('tenant') && tenant()) {
                $data['tenant_id'] = tenant()->id;
            }

            $facility = Facility::create($data);

            activity_log(
                event: 'facility.create',
                description: "Created new facility: {$facility->name}",
                tenantId: $facility->tenant_id
            );

            return $facility;
        });
    }

    public function updateFacility(Facility $facility, array $data): Facility
    {
        return DB::transaction(function () use ($facility, $data) {
            if (isset($data['name']) && $data['name'] !== $facility->name) {
                $slug = Str::slug($data['name']);
                $originalSlug = $slug;
                $count = 1;
                
                $query = Facility::query();
                if ($facility->tenant_id) {
                    $query->where('tenant_id', $facility->tenant_id);
                } else {
                    $query->whereNull('tenant_id');
                }

                while ((clone $query)->where('slug', $slug)->where('id', '!=', $facility->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                $data['slug'] = $slug;
            }

            $facility->update($data);

            activity_log(
                event: 'facility.update',
                description: "Updated facility: {$facility->name}",
                tenantId: $facility->tenant_id
            );

            return $facility;
        });
    }

    public function deleteFacility(Facility $facility): void
    {
        DB::transaction(function () use ($facility) {
            $name = $facility->name;
            $tenantId = $facility->tenant_id;
            
            $facility->delete();

            activity_log(
                event: 'facility.delete',
                description: "Deleted facility: {$name}",
                tenantId: $tenantId
            );
        });
    }

    public function syncFacilityOrder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                Facility::where('id', $id)->update(['display_order' => $index]);
            }
        });
    }
}
