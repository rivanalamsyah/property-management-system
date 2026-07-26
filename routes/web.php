<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Workspace\CreateWorkspace;
use App\Livewire\Profile\UserProfile;
use App\Livewire\Settings\TenantSettings;
use App\Livewire\Dashboard;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\MarketingController;

// Public Marketing Routes
Route::get('/', [MarketingController::class, 'home'])->name('home');
Route::get('/features', [MarketingController::class, 'features'])->name('features');
Route::get('/pricing', [MarketingController::class, 'pricing'])->name('pricing');
Route::get('/resources', [MarketingController::class, 'resources'])->name('resources');
Route::get('/about', [MarketingController::class, 'about'])->name('about');
Route::get('/contact', [MarketingController::class, 'contact'])->name('contact');
Route::get('/privacy', [MarketingController::class, 'privacy'])->name('privacy');
Route::get('/terms', [MarketingController::class, 'terms'])->name('terms');

Route::get('/sitemap.xml', [MarketingController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [MarketingController::class, 'robots'])->name('robots');

// Offline fallback page
Route::get('/offline', function () {
    return view('errors.offline');
})->name('offline');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // Logout Handler
    Route::post('/logout', function () {
        $user = auth()->user();
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        activity_log(
            event: 'auth.logout',
            description: "User logged out: {$user->email}",
            userId: $user->id
        );
        
        return redirect()->route('login');
    })->name('logout');

    // Email Verification Notice
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');

    // Email Verification Handler
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        
        activity_log(
            event: 'auth.email_verified',
            description: "User email verified: " . auth()->user()->email
        );
        
        return redirect()->route('dashboard');
    })->middleware('signed')->name('verification.verify');

    // Switch Workspace
    Route::get('/tenant/switch/{tenant}', function (\App\Models\Tenant $tenant) {
        if (auth()->user()->tenants()->where('tenant_id', $tenant->id)->exists()) {
            session()->put('tenant_id', $tenant->id);
            return redirect()->back();
        }
        abort(403, 'Unauthorized workspace switch.');
    })->name('tenant.switch');

    // Workspace Onboarding
    Route::get('/dashboard/workspaces/create', CreateWorkspace::class)->name('workspace.create');
    Route::get('/onboarding', \App\Livewire\Workspace\OnboardingWizard::class)->name('onboarding');

    // Core Dashboard Group (Requires verified email and having an active workspace)
    Route::middleware(['verified'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/dashboard/profile', UserProfile::class)->name('profile');
        Route::get('/dashboard/settings', TenantSettings::class)->name('settings');
        Route::get('/dashboard/settings/platform', \App\Livewire\Settings\PlatformSettings::class)->name('settings.platform');
        Route::get('/dashboard/monitoring', \App\Livewire\Monitoring\MonitoringConsole::class)->name('monitoring.console');
        Route::get('/dashboard/security', \App\Livewire\Security\SecurityCenter::class)->name('security.center');
        Route::get('/dashboard/backups', \App\Livewire\Backup\BackupCenter::class)->name('backup.center');
        Route::get('/dashboard/billing', \App\Livewire\Settings\BillingPortal::class)->name('billing');
        Route::get('/dashboard/workspaces', \App\Livewire\Workspace\WorkspaceSearch::class)->name('workspaces.index');

        // Enterprise CMS Routes
        Route::get('/dashboard/cms', \App\Livewire\CMS\CmsDashboard::class)->name('cms.dashboard');
        Route::get('/dashboard/cms/pages', \App\Livewire\CMS\CmsPageList::class)->name('cms.pages.index');
        Route::get('/dashboard/cms/pages/{id}/edit', \App\Livewire\CMS\CmsPageEditor::class)->name('cms.pages.edit');
        Route::get('/dashboard/cms/blog', \App\Livewire\CMS\CmsBlogList::class)->name('cms.blog.index');
        Route::get('/dashboard/cms/blog/create', \App\Livewire\CMS\CmsBlogEditor::class)->name('cms.blog.create');
        Route::get('/dashboard/cms/blog/{id}/edit', \App\Livewire\CMS\CmsBlogEditor::class)->name('cms.blog.edit');
        Route::get('/dashboard/cms/media', \App\Livewire\CMS\CmsMediaManager::class)->name('cms.media');
        Route::get('/dashboard/cms/menus', \App\Livewire\CMS\CmsMenuEditor::class)->name('cms.menus.edit');
        Route::get('/dashboard/cms/globals', \App\Livewire\CMS\CmsGlobalEditor::class)->name('cms.globals');

        // Master Boarding House (Kos)
        Route::get('/dashboard/boarding-houses', \App\Livewire\BoardingHouse\BoardingHouseList::class)->name('boarding-houses');
        Route::get('/dashboard/boarding-houses/create', \App\Livewire\BoardingHouse\BoardingHouseForm::class)->name('boarding-houses.create');
        Route::get('/dashboard/boarding-houses/{id}/edit', \App\Livewire\BoardingHouse\BoardingHouseForm::class)->name('boarding-houses.edit');

        // Room Management
        Route::get('/dashboard/rooms', \App\Livewire\Room\RoomList::class)->name('rooms');
        Route::get('/dashboard/rooms/create', \App\Livewire\Room\RoomForm::class)->name('rooms.create');
        Route::get('/dashboard/rooms/{id}/edit', \App\Livewire\Room\RoomForm::class)->name('rooms.edit');

        // Resident (Tenant) Management
        Route::get('/dashboard/residents', \App\Livewire\Resident\ResidentList::class)->name('residents');
        Route::get('/dashboard/residents/create', \App\Livewire\Resident\ResidentForm::class)->name('residents.create');
        Route::get('/dashboard/residents/{id}/edit', \App\Livewire\Resident\ResidentForm::class)->name('residents.edit');
        Route::get('/dashboard/residents/{id}', \App\Livewire\Resident\ResidentShow::class)->name('residents.show');

        // Contract Management
        Route::get('/dashboard/contracts', \App\Livewire\Contract\ContractList::class)->name('contracts');
        Route::get('/dashboard/contracts/create', \App\Livewire\Contract\ContractForm::class)->name('contracts.create');
        Route::get('/dashboard/contracts/{id}/edit', \App\Livewire\Contract\ContractForm::class)->name('contracts.edit');
        Route::get('/dashboard/contracts/{id}', \App\Livewire\Contract\ContractShow::class)->name('contracts.show');

        // Billing Management
        Route::get('/dashboard/invoices', \App\Livewire\Billing\BillingList::class)->name('invoices');
        Route::get('/dashboard/invoices/{id}', \App\Livewire\Billing\InvoiceShow::class)->name('invoices.show');

        // Payment Management
        Route::get('/dashboard/payments', \App\Livewire\Payment\PaymentList::class)->name('payments');
        Route::get('/dashboard/payments/{id}', \App\Livewire\Payment\PaymentShow::class)->name('payments.show');

        // Complaint & Maintenance Management
        Route::get('/dashboard/complaints', \App\Livewire\Complaint\ComplaintList::class)->name('complaints');
        Route::get('/dashboard/complaints/{id}', \App\Livewire\Complaint\ComplaintShow::class)->name('complaints.show');

        // Facilities Management
        Route::get('/dashboard/facilities', \App\Livewire\Settings\FacilityManager::class)->name('facilities');

        // Announcement & Broadcast Management
        Route::get('/dashboard/announcements', \App\Livewire\Announcement\AnnouncementList::class)->name('announcements');
        Route::get('/dashboard/announcements/{id}', \App\Livewire\Announcement\AnnouncementShow::class)->name('announcements.show');

        // Reports & Business Intelligence Analytics
        Route::get('/dashboard/analytics', \App\Livewire\Analytics\AnalyticsDashboard::class)->name('analytics.dashboard');
        Route::get('/dashboard/analytics/saved-presets', \App\Livewire\Analytics\SavedReportsList::class)->name('analytics.presets');
    });

});
