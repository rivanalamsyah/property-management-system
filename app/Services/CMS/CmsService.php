<?php

namespace App\Services\CMS;

use App\Models\CmsRevision;
use App\Enums\CmsPublishStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CmsService
{
    /**
     * Create a content revision snapshot for a model.
     */
    public function createRevision(Model $model, array $content): CmsRevision
    {
        $latest = CmsRevision::where('revisable_type', get_class($model))
            ->where('revisable_id', $model->getKey())
            ->orderBy('version_number', 'desc')
            ->first();

        $versionNumber = $latest ? $latest->version_number + 1 : 1;

        return CmsRevision::create([
            'revisable_type' => get_class($model),
            'revisable_id' => $model->getKey(),
            'content' => $content,
            'user_id' => Auth::id(),
            'version_number' => $versionNumber,
            'created_at' => now(),
        ]);
    }

    /**
     * Restore a model to a specific revision.
     */
    public function restoreRevision(Model $model, string $revisionId): bool
    {
        $revision = CmsRevision::where('revisable_type', get_class($model))
            ->where('revisable_id', $model->getKey())
            ->findOrFail($revisionId);

        // Fill and save revision content to target model
        $model->update($revision->content);

        return true;
    }

    /**
     * Check if a content is active under current time and status constraints.
     */
    public function isCurrentlyPublished(?CmsPublishStatus $status, ?Carbon $publishedAt, ?Carbon $expiredAt): bool
    {
        if ($status !== CmsPublishStatus::PUBLISHED) {
            return false;
        }

        $now = now();

        if ($publishedAt && $now->lessThan($publishedAt)) {
            return false; // Scheduled in the future
        }

        if ($expiredAt && $now->greaterThan($expiredAt)) {
            return false; // Expired
        }

        return true;
    }
}
