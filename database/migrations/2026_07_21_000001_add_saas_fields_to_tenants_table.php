<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('name');
            $table->string('brand_name')->nullable()->after('company_name');
            $table->string('logo')->nullable()->after('brand_name');
            
            // Localization
            $table->string('timezone')->default('Asia/Jakarta')->after('logo');
            $table->string('currency')->default('IDR')->after('timezone');
            $table->string('language')->default('id')->after('currency');
            $table->string('country')->default('ID')->after('language');
            
            // Subscription & trial parameters
            $table->uuid('subscription_plan_id')->nullable()->after('status');
            $table->string('subscription_status')->default('trial')->after('subscription_plan_id');
            $table->timestamp('trial_ends_at')->nullable()->after('subscription_status');
            $table->timestamp('subscription_ends_at')->nullable()->after('trial_ends_at');
            $table->timestamp('next_billing_at')->nullable()->after('subscription_ends_at');
            $table->timestamp('trial_reminder_sent_at')->nullable()->after('next_billing_at');
            $table->timestamp('grace_period_ends_at')->nullable()->after('trial_reminder_sent_at');
            
            // Feature flags & overrides
            $table->json('feature_flags')->nullable()->after('grace_period_ends_at');
            $table->json('custom_limits')->nullable()->after('feature_flags');
            
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropForeign(['subscription_plan_id']);
            $table->dropColumn([
                'company_name',
                'brand_name',
                'logo',
                'timezone',
                'currency',
                'language',
                'country',
                'subscription_plan_id',
                'subscription_status',
                'trial_ends_at',
                'subscription_ends_at',
                'next_billing_at',
                'trial_reminder_sent_at',
                'grace_period_ends_at',
                'feature_flags',
                'custom_limits',
            ]);
        });
    }
};
