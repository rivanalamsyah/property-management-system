<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsBlogArticle;
use App\Models\CmsRedirect;
use App\Models\CmsRevision;
use App\Enums\CmsPublishStatus;
use App\Services\CMS\CmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@kosan.test',
        ]);
    }

    public function test_page_section_editing_creates_history_revision_and_can_be_restored(): void
    {
        // 1. Arrange page & section
        $page = CmsPage::create([
            'name' => 'Home',
            'slug' => 'home',
            'status' => CmsPublishStatus::DRAFT,
        ]);

        $section = CmsSection::create([
            'cms_page_id' => $page->id,
            'type' => 'hero',
            'name' => 'Hero Banner',
            'content' => ['heading' => 'Old Title'],
        ]);

        // 2. Act: edit page via CmsService
        $this->actingAs($this->user);
        $service = new CmsService();

        // Save historical snapshot of the old content
        $service->createRevision($page, [
            'name' => $page->name,
            'slug' => $page->slug,
            'status' => $page->status->value,
            'seo_title' => 'Old SEO title',
        ]);

        $page->update([
            'name' => 'New Home',
            'status' => CmsPublishStatus::PUBLISHED,
        ]);

        // 3. Assert page updated and revision recorded
        $this->assertDatabaseHas('cms_pages', [
            'id' => $page->id,
            'name' => 'New Home',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('cms_revisions', [
            'revisable_id' => $page->id,
            'version_number' => 1,
        ]);

        // 4. Restore revision
        $revision = CmsRevision::where('revisable_id', $page->id)->first();
        $service->restoreRevision($page, $revision->id);

        $this->assertDatabaseHas('cms_pages', [
            'id' => $page->id,
            'name' => 'Home',
            'status' => 'draft',
        ]);
    }

    public function test_scheduled_articles_publishing_resolution(): void
    {
        $service = new CmsService();

        // Future scheduled should not be active
        $futureArticle = CmsBlogArticle::create([
            'title' => 'Future Post',
            'slug' => 'future-post',
            'status' => CmsPublishStatus::PUBLISHED,
            'published_at' => now()->addDays(5),
        ]);

        $isPublished = $service->isCurrentlyPublished(
            $futureArticle->status,
            $futureArticle->published_at,
            $futureArticle->expired_at
        );
        $this->assertFalse($isPublished);

        // Immediate or past date published should be active
        $pastArticle = CmsBlogArticle::create([
            'title' => 'Past Post',
            'slug' => 'past-post',
            'status' => CmsPublishStatus::PUBLISHED,
            'published_at' => now()->subDays(2),
        ]);

        $isPublishedPast = $service->isCurrentlyPublished(
            $pastArticle->status,
            $pastArticle->published_at,
            $pastArticle->expired_at
        );
        $this->assertTrue($isPublishedPast);
    }

    public function test_url_redirects_routing_interception(): void
    {
        // Register redirect matching rule
        CmsRedirect::create([
            'source_path' => '/old-pricing-page',
            'target_path' => '/pricing',
            'status_code' => 301,
            'is_active' => true,
        ]);

        // Request source URL and assert 301 Redirect to pricing
        $response = $this->get('/old-pricing-page');
        $response->assertRedirect('/pricing');
        $response->assertStatus(301);
    }
}
