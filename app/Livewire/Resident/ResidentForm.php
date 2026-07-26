<?php

namespace App\Livewire\Resident;

use App\Models\Resident;
use App\Services\ResidentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResidentForm extends Component
{
    use WithFileUploads;

    public ?string $residentId = null;

    // Fields
    public string $name = '';
    public string $nik = '';
    public string $gender = 'male';
    public string $date_of_birth = '';
    public string $place_of_birth = '';
    public string $nationality = 'WNI';
    public string $occupation = '';
    public string $marital_status = 'single';
    public string $religion = '';
    public $photoUpload = null;

    // Contact
    public string $phone = '';
    public string $whatsapp = '';
    public string $email = '';

    // Emergency Contact
    public string $emergency_name = '';
    public string $emergency_relationship = '';
    public string $emergency_phone = '';
    public string $emergency_address = '';

    // Address
    public string $province = '';
    public string $city = '';
    public string $district = '';
    public string $postal_code = '';
    public string $address = '';

    public function mount(?string $id = null): void
    {
        $this->residentId = $id;

        if ($id) {
            $resident = Resident::findOrFail($id);

            if (Auth::user()->cannot('view', $resident)) {
                abort(403, 'Unauthorized.');
            }

            $this->name = $resident->name;
            $this->nik = $resident->nik;
            $this->gender = $resident->gender;
            $this->date_of_birth = $resident->date_of_birth->format('Y-m-d');
            $this->place_of_birth = $resident->place_of_birth;
            $this->nationality = $resident->nationality;
            $this->occupation = $resident->occupation;
            $this->marital_status = $resident->marital_status;
            $this->religion = $resident->religion ?? '';
            
            $this->phone = $resident->phone;
            $this->whatsapp = $resident->whatsapp;
            $this->email = $resident->email;

            $this->emergency_name = $resident->emergency_name;
            $this->emergency_relationship = $resident->emergency_relationship;
            $this->emergency_phone = $resident->emergency_phone;
            $this->emergency_address = $resident->emergency_address;

            $this->province = $resident->province;
            $this->city = $resident->city;
            $this->district = $resident->district;
            $this->postal_code = $resident->postal_code;
            $this->address = $resident->address;
        } else {
            if (Auth::user()->cannot('create', Resident::class)) {
                abort(403, 'Unauthorized.');
            }
        }
    }

    public function saveResident(ResidentService $service): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'string',
                'numeric',
                'digits:16',
                Rule::unique('residents')
                    ->where('tenant_id', tenant()->id)
                    ->ignore($this->residentId),
            ],
            'gender' => ['required', 'string', 'in:male,female'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string', 'max:100'],
            'occupation' => ['required', 'string', 'max:255'],
            'marital_status' => ['required', 'string', 'in:single,married,divorced'],
            'religion' => ['nullable', 'string', 'max:100'],
            'photoUpload' => ['nullable', 'image', 'max:1024'], // 1MB

            'phone' => ['required', 'string', 'max:50'],
            'whatsapp' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('residents')
                    ->where('tenant_id', tenant()->id)
                    ->ignore($this->residentId),
            ],

            'emergency_name' => ['required', 'string', 'max:255'],
            'emergency_relationship' => ['required', 'string', 'max:100'],
            'emergency_phone' => ['required', 'string', 'max:50'],
            'emergency_address' => ['required', 'string', 'max:500'],

            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        $data = [
            'name' => $this->name,
            'nik' => $this->nik,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'nationality' => $this->nationality,
            'occupation' => $this->occupation,
            'marital_status' => $this->marital_status,
            'religion' => $this->religion,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'email' => $this->email,
            'emergency_name' => $this->emergency_name,
            'emergency_relationship' => $this->emergency_relationship,
            'emergency_phone' => $this->emergency_phone,
            'emergency_address' => $this->emergency_address,
            'province' => $this->province,
            'city' => $this->city,
            'district' => $this->district,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
        ];

        if ($this->photoUpload) {
            $data['photo'] = $this->photoUpload->store('photos', 'public');
        }

        try {
            if ($this->residentId) {
                $resident = Resident::findOrFail($this->residentId);
                
                if (Auth::user()->cannot('update', $resident)) {
                    abort(403, 'Unauthorized.');
                }

                if ($this->photoUpload && $resident->photo) {
                    Storage::disk('public')->delete($resident->photo);
                }

                $service->updateResident($resident, $data);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Resident record updated.']);
            } else {
                $resident = $service->createResident($data);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Resident registered! Proceed to configure check-in.']);
            }

            $this->redirect(route('residents.show', $resident->id));
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $resident = $this->residentId ? Resident::findOrFail($this->residentId) : null;

        return view('livewire.resident.resident-form', [
            'resident' => $resident,
        ])->layout('layouts.app');
    }
}
