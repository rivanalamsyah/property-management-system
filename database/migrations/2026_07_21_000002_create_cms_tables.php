<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Predefined Pages
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            
            // SEO fields
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->json('seo_meta')->nullable(); // og, twitter, schema.org

            $table->string('status')->default('draft'); // draft, published, scheduled
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });

        // 2. Sections in Pages (fixed layout, editable content)
        Schema::create('cms_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cms_page_id')->constrained('cms_pages')->cascadeOnDelete();
            $table->string('type'); // hero, feature_grid, stats, testimonials, pricing, faq, cta, gallery, contacts, newsletter
            $table->string('name');
            $table->json('content')->nullable(); // structured values depending on type
            $table->integer('display_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // 3. Blog Categories
        Schema::create('cms_blog_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 4. Blog Tags
        Schema::create('cms_blog_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 5. Blog Articles
        Schema::create('cms_blog_articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('author_name')->nullable();

            // Status & Dates
            $table->string('status')->default('draft'); // draft, published, scheduled, archived
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expired_at')->nullable();

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->json('seo_meta')->nullable();

            $table->timestamps();
        });

        // Pivot tables for Blog categories & tags
        Schema::create('cms_article_category', function (Blueprint $table) {
            $table->foreignUuid('article_id')->references('id')->on('cms_blog_articles')->cascadeOnDelete();
            $table->foreignUuid('category_id')->references('id')->on('cms_blog_categories')->cascadeOnDelete();
            $table->primary(['article_id', 'category_id']);
        });

        Schema::create('cms_article_tag', function (Blueprint $table) {
            $table->foreignUuid('article_id')->references('id')->on('cms_blog_articles')->cascadeOnDelete();
            $table->foreignUuid('tag_id')->references('id')->on('cms_blog_tags')->cascadeOnDelete();
            $table->primary(['article_id', 'tag_id']);
        });

        // 6. Media Library
        Schema::create('cms_media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename');
            $table->string('filepath');
            $table->string('file_url');
            $table->string('mime_type');
            $table->integer('file_size'); // bytes
            $table->string('folder')->default('/');
            $table->string('alt_text')->nullable();
            $table->json('responsive_variants')->nullable();
            $table->timestamps();
        });

        // 7. Nested Menus
        Schema::create('cms_menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique(); // header_menu, footer_menu, quick_links, social_links
            $table->json('items')->nullable(); // structured nested array
            $table->timestamps();
        });

        // 8. FAQs
        Schema::create('cms_faqs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('category');
            $table->string('question');
            $table->text('answer');
            $table->integer('display_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // 9. Testimonials
        Schema::create('cms_testimonials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_name');
            $table->string('avatar')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->integer('rating')->default(5);
            $table->text('review');
            $table->integer('display_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // 10. Partner Logos
        Schema::create('cms_partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('logo_url');
            $table->string('link_url')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // 11. Homepage Banners
        Schema::create('cms_banners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type'); // homepage_banner, announcement_banner, promotion_banner, cta_banner
            $table->text('content');
            $table->string('action_label')->nullable();
            $table->string('action_url')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        // 12. URL Redirects
        Schema::create('cms_redirects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('source_path')->unique();
            $table->string('target_path');
            $table->integer('status_code')->default(301); // 301, 302
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 13. Revisions (Snapshots for rollback history)
        Schema::create('cms_revisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('revisable_type');
            $table->string('revisable_id');
            $table->json('content');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('version_number')->default(1);
            $table->timestamp('created_at')->nullable();
        });

        // 14. Globals Key-Value Properties
        Schema::create('cms_globals', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_globals');
        Schema::dropIfExists('cms_revisions');
        Schema::dropIfExists('cms_redirects');
        Schema::dropIfExists('cms_banners');
        Schema::dropIfExists('cms_partners');
        Schema::dropIfExists('cms_testimonials');
        Schema::dropIfExists('cms_faqs');
        Schema::dropIfExists('cms_menus');
        Schema::dropIfExists('cms_media');
        Schema::dropIfExists('cms_article_tag');
        Schema::dropIfExists('cms_article_category');
        Schema::dropIfExists('cms_blog_articles');
        Schema::dropIfExists('cms_blog_tags');
        Schema::dropIfExists('cms_blog_categories');
        Schema::dropIfExists('cms_sections');
        Schema::dropIfExists('cms_pages');
    }
};
