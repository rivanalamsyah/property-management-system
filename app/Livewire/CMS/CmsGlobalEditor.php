<?php

namespace App\Livewire\CMS;

use App\Models\CmsGlobal;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CmsGlobalEditor extends Component
{
    public array $globals = [];

    // Fields mapping
    public string $company_profile = '';
    public string $address = '';
    public string $email = '';
    public string $phone = '';
    public string $whatsapp = '';
    public string $business_hours = '';
    public string $facebook = '';
    public string $instagram = '';
    public string $linkedin = '';
    public string $footer_info = '';
    public string $copyright = '';

    public function mount(): void
    {
        $keys = [
            'company_profile',
            'address',
            'email',
            'phone',
            'whatsapp',
            'business_hours',
            'facebook',
            'instagram',
            'linkedin',
            'footer_info',
            'copyright',
        ];

        foreach ($keys as $key) {
            $record = CmsGlobal::where('key', $key)->first();
            $this->{$key} = $record ? $record->value : '';
        }
    }

    public function saveGlobals(): void
    {
        $keys = [
            'company_profile',
            'address',
            'email',
            'phone',
            'whatsapp',
            'business_hours',
            'facebook',
            'instagram',
            'linkedin',
            'footer_info',
            'copyright',
        ];

        foreach ($keys as $key) {
            CmsGlobal::updateOrCreate(
                ['key' => $key],
                ['value' => $this->{$key}]
            );
        }

        activity_log(
            event: 'cms.global_update',
            description: "CMS global configurations saved",
            userId: Auth::id()
        );

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Global configurations saved!']);
    }

    public function render()
    {
        return view('livewire.cms.cms-global-editor');
    }
}
