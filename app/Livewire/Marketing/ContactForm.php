<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $company_name = '';
    public string $property_size = '11-50'; // default
    public string $message = '';
    
    public ?string $successMessage = null;

    protected array $rules = [
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:150'],
        'phone' => ['required', 'string', 'max:20'],
        'company_name' => ['required', 'string', 'max:150'],
        'property_size' => ['required', 'string', 'in:1-10,11-50,51-200,200+'],
        'message' => ['required', 'string', 'max:2000'],
    ];

    protected array $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'phone.required' => 'Nomor WhatsApp wajib diisi.',
        'company_name.required' => 'Nama usaha/brand kos wajib diisi.',
        'property_size.required' => 'Pilih jumlah kamar terkelola.',
        'message.required' => 'Pesan atau kebutuhan Anda wajib diisi.',
    ];

    public function submitDemoRequest(): void
    {
        $this->validate();

        // Log submission details to application logs
        Log::info("Demo request received from: {$this->name} - Email: {$this->email} - Company: {$this->company_name} - Rooms Size: {$this->property_size} rooms. Message: {$this->message}");

        activity_log(
            event: 'marketing.demo_request',
            description: "Demo request received from {$this->name} ({$this->company_name})",
            properties: [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'company_name' => $this->company_name,
                'property_size' => $this->property_size,
            ]
        );

        $this->reset(['name', 'email', 'phone', 'company_name', 'message']);
        
        $this->successMessage = 'Terima kasih! Permintaan demo Anda telah berhasil terdaftar. Tim spesialis kami akan menghubungi Anda dalam waktu 1x24 jam.';
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Permintaan demo berhasil terkirim.',
        ]);
    }

    public function render()
    {
        return view('livewire.marketing.contact-form');
    }
}
