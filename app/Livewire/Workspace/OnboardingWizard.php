<?php

namespace App\Livewire\Workspace;

use App\Models\Tenant;
use App\Models\BoardingHouse;
use App\Models\SubscriptionPlan;
use App\Enums\WorkspaceStatus;
use App\Enums\SubscriptionStatus;
use App\Services\SaaS\ImportService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Exception;

class OnboardingWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;

    // Step 1: Workspace Settings
    public string $company_name = '';
    public string $brand_name = '';
    public string $timezone = 'Asia/Jakarta';
    public string $currency = 'IDR';
    public string $language = 'id';
    public string $country = 'ID';

    // Step 2: Boarding House details
    public string $house_name = '';
    public string $house_address = '';
    public string $house_province = 'Jawa Barat';
    public string $house_city = 'Bandung';
    public string $house_whatsapp = '';

    // Step 3: Room CSV Import
    public $room_csv;
    public array $rooms_preview = [];
    public bool $rooms_has_errors = false;
    public string $rooms_error_message = '';

    // Step 4: Resident CSV Import
    public $resident_csv;
    public array $residents_preview = [];
    public bool $residents_has_errors = false;
    public string $residents_error_message = '';

    protected function rules(): array
    {
        if ($this->step === 1) {
            return [
                'company_name' => ['required', 'string', 'max:255'],
                'brand_name' => ['required', 'string', 'max:255'],
                'timezone' => ['required', 'string'],
                'currency' => ['required', 'string', 'size:3'],
                'language' => ['required', 'string', 'max:5'],
                'country' => ['required', 'string', 'size:2'],
            ];
        }

        if ($this->step === 2) {
            return [
                'house_name' => ['required', 'string', 'max:255'],
                'house_address' => ['required', 'string', 'max:500'],
                'house_province' => ['required', 'string', 'max:100'],
                'house_city' => ['required', 'string', 'max:100'],
                'house_whatsapp' => ['required', 'string', 'min:9', 'max:15'],
            ];
        }

        return [];
    }

    public function mount(): void
    {
        $tenant = tenant();
        if (!$tenant || $tenant->status !== WorkspaceStatus::PENDING) {
            $this->redirect(route('dashboard'));
            return;
        }

        $this->company_name = $tenant->name;
        $this->brand_name = $tenant->name;
        $this->house_name = $tenant->name . ' House';
    }

    public function nextStep(): void
    {
        $this->validate();

        if ($this->step === 1) {
            $this->step = 2;
        } elseif ($this->step === 2) {
            $this->step = 3;
        } elseif ($this->step === 3) {
            $this->step = 4;
        } elseif ($this->step === 4) {
            $this->step = 5;
        }
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    /**
     * Parse Room CSV and generate a preview in session/component memory.
     */
    public function updatedRoomCsv(): void
    {
        $this->rooms_error_message = '';
        $this->rooms_preview = [];
        $this->rooms_has_errors = false;

        $this->validate([
            'room_csv' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        try {
            $importService = app(ImportService::class);
            $requiredHeaders = ['room_number', 'monthly_rent'];
            
            $rows = $importService->parseCsv($this->room_csv->getRealPath(), $requiredHeaders);
            
            // Temporary UUID or placeholder boarding house ID for preview validation
            $this->rooms_preview = $importService->previewRooms($rows, 'placeholder-id');
            
            foreach ($this->rooms_preview as $p) {
                if (!$p['is_valid']) {
                    $this->rooms_has_errors = true;
                }
            }
        } catch (Exception $e) {
            $this->rooms_error_message = $e->getMessage();
        }
    }

    /**
     * Parse Resident CSV and generate a preview.
     */
    public function updatedResidentCsv(): void
    {
        $this->residents_error_message = '';
        $this->residents_preview = [];
        $this->residents_has_errors = false;

        $this->validate([
            'resident_csv' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        try {
            $importService = app(ImportService::class);
            $requiredHeaders = ['name', 'nik', 'email'];
            
            $rows = $importService->parseCsv($this->resident_csv->getRealPath(), $requiredHeaders);
            $this->residents_preview = $importService->previewResidents($rows, tenant()->id);
            
            foreach ($this->residents_preview as $p) {
                if (!$p['is_valid']) {
                    $this->residents_has_errors = true;
                }
            }
        } catch (Exception $e) {
            $this->residents_error_message = $e->getMessage();
        }
    }

    public function downloadRoomTemplate()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=rooms_template.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['room_number', 'floor', 'room_type', 'monthly_rent', 'security_deposit', 'room_size', 'status'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['101', '1', 'Standard', '1200000', '500000', '3x4', 'vacant']);
            fputcsv($file, ['102', '1', 'Deluxe', '1500000', '500000', '3x4', 'vacant']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadResidentTemplate()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=residents_template.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['name', 'nik', 'email', 'phone', 'gender', 'occupation'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['Rudi Setiawan', '3273012345678901', 'rudi@gmail.com', '081299998888', 'male', 'Developer']);
            fputcsv($file, ['Siti Aminah', '3273012345678902', 'siti@gmail.com', '081299998889', 'female', 'Mahasiswi']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Finalize workspace onboarding and redirect to dashboard.
     */
    public function finishOnboarding(): void
    {
        $tenant = tenant();
        $importService = app(ImportService::class);

        // 1. Update Tenant SaaS details
        // Get Default Trial Plan (Professional)
        $trialPlan = SubscriptionPlan::where('slug', 'professional')->first();

        $tenant->update([
            'company_name' => $this->company_name,
            'brand_name' => $this->brand_name,
            'timezone' => $this->timezone,
            'currency' => $this->currency,
            'language' => $this->language,
            'country' => $this->country,
            'subscription_plan_id' => $trialPlan?->id,
            'subscription_status' => SubscriptionStatus::TRIAL,
            'status' => WorkspaceStatus::ACTIVE,
            'trial_ends_at' => now()->addDays(14),
            'grace_period_ends_at' => now()->addDays(21), // 7 days grace period
        ]);

        // 2. Create Boarding House
        $bh = BoardingHouse::create([
            'tenant_id' => $tenant->id,
            'name' => $this->house_name,
            'slug' => \Illuminate\Support\Str::slug($this->house_name),
            'description' => 'Automatically generated during workspace onboarding.',
            'address' => $this->house_address,
            'province' => $this->house_province,
            'city' => $this->house_city,
            'district' => 'Kecamatan',
            'postal_code' => '40111',
            'whatsapp_number' => $this->house_whatsapp,
            'email' => Auth::user()->email,
            'status' => 'active',
            'is_public' => true,
            'settings' => BoardingHouse::defaultSettings(),
        ]);

        // 3. Commit Rooms Import (if uploaded and valid)
        if ($this->room_csv && !$this->rooms_has_errors && !empty($this->rooms_preview)) {
            // Update boarding house ID mapping
            foreach ($this->rooms_preview as &$p) {
                $p['data']['boarding_house_id'] = $bh->id;
            }
            $importService->importRooms($this->rooms_preview);
        }

        // 4. Commit Residents Import (if uploaded and valid)
        if ($this->resident_csv && !$this->residents_has_errors && !empty($this->residents_preview)) {
            $importService->importResidents($this->residents_preview);
        }

        // 5. Activity log
        activity_log(
            event: 'tenant.onboarding_completed',
            description: "Workspace onboarding wizard completed successfully: {$tenant->name}",
            userId: Auth::id(),
            tenantId: $tenant->id
        );

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Workspace setup completed successfully!']);
        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.workspace.onboarding-wizard')
            ->layout('layouts.auth');
    }
}
