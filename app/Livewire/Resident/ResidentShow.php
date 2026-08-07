<?php

namespace App\Livewire\Resident;

use App\Models\BoardingHouse;
use App\Models\Resident;
use App\Models\ResidentDocument;
use App\Models\Room;
use App\Services\ResidentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResidentShow extends Component
{
    use WithFileUploads;

    public string $residentId;
    public string $activeTab = 'check'; // check, documents, timeline

    // Check-In fields
    public string $check_in_boarding_house_id = '';
    public string $check_in_room_id = '';
    public string $check_in_date = '';
    public string $move_in_time = '09:00';
    public ?float $initial_meter_reading = null;
    public float $security_deposit = 0.00;
    public string $check_in_notes = '';

    // Check-Out fields
    public string $check_out_date = '';
    public ?float $final_meter_reading = null;
    public string $check_out_notes = '';
    public string $damage_notes = '';

    // Document uploads
    public string $docType = 'KTP';
    public $docUpload = null;
    public string $docLabel = '';

    public function mount(string $id): void
    {
        $this->residentId = $id;
        $resident = Resident::findOrFail($id);

        if (Auth::user()->can('view', $resident)) {
            $this->check_in_date = date('Y-m-d');
            $this->check_out_date = date('Y-m-d');

            // Default check-in boarding house selection
            $firstHouse = BoardingHouse::first();
            if ($firstHouse) {
                $this->check_in_boarding_house_id = $firstHouse->id;
            }
        } else {
            abort(403, 'Unauthorized.');
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function executeCheckIn(ResidentService $service): void
    {
        $this->validate([
            'check_in_room_id' => ['required', 'uuid', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date'],
            'move_in_time' => ['nullable', 'string'],
            'initial_meter_reading' => ['nullable', 'numeric', 'min:0'],
            'security_deposit' => ['required', 'numeric', 'min:0'],
            'check_in_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $resident = Resident::findOrFail($this->residentId);
        
        $checkInData = [
            'room_id' => $this->check_in_room_id,
            'check_in_date' => $this->check_in_date,
            'move_in_time' => $this->move_in_time,
            'initial_meter_reading' => $this->initial_meter_reading,
            'security_deposit' => $this->security_deposit,
            'check_in_notes' => $this->check_in_notes,
        ];

        try {
            $service->checkIn($resident, $checkInData);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Proses check-in berhasil diselesaikan! Status kamar kini menjadi terisi.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function executeCheckOut(ResidentService $service): void
    {
        $this->validate([
            'check_out_date' => ['required', 'date', 'after_or_equal:check_in_date'],
            'final_meter_reading' => ['nullable', 'numeric', 'min:0'],
            'check_out_notes' => ['nullable', 'string', 'max:500'],
            'damage_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $resident = Resident::findOrFail($this->residentId);

        // Ensure final meter is larger than initial meter
        if ($resident->initial_meter_reading && $this->final_meter_reading && $this->final_meter_reading < $resident->initial_meter_reading) {
            $this->addError('final_meter_reading', 'Angka meteran akhir tidak boleh lebih rendah dari meteran awal (' . $resident->initial_meter_reading . ' kWh).');
            return;
        }

        $checkOutData = [
            'check_out_date' => $this->check_out_date,
            'final_meter_reading' => $this->final_meter_reading,
            'check_out_notes' => $this->check_out_notes,
            'damage_notes' => $this->damage_notes,
        ];

        try {
            $service->checkOut($resident, $checkOutData);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Proses check-out berhasil diselesaikan! Status kamar kembali menjadi tersedia.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function uploadDocument(ResidentService $service): void
    {
        $this->validate([
            'docUpload' => ['required', 'file', 'max:2048', 'mimes:jpg,jpeg,png,pdf'], // Max 2MB
            'docType' => ['required', 'string', 'in:KTP,Passport,Family Card,Student Card,Employee Card'],
            'docLabel' => ['nullable', 'string', 'max:100'],
        ]);

        $resident = Resident::findOrFail($this->residentId);
        $path = $this->docUpload->store('documents', 'public');

        $service->addDocument($resident, $this->docType, $path, $this->docLabel);

        $this->reset(['docUpload', 'docLabel']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Dokumen berhasil dilampirkan ke profil penghuni.']);
    }

    public function deleteDocument(int $id, ResidentService $service): void
    {
        $doc = ResidentDocument::findOrFail($id);
        $service->removeDocument($doc);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Dokumen berhasil dihapus.']);
    }

    public function render()
    {
        $resident = Resident::with(['boardingHouse', 'room', 'documents', 'timeline'])->findOrFail($this->residentId);

        // Fetch available rooms matching selected boarding house
        $availableRooms = Room::where('boarding_house_id', $this->check_in_boarding_house_id)
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();

        return view('livewire.resident.resident-show', [
            'resident' => $resident,
            'availableRooms' => $availableRooms,
        ])->layout('layouts.app');
    }
}
