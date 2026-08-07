<?php

namespace App\Livewire\Contract;

use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Resident;
use App\Models\Room;
use App\Services\ContractService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContractForm extends Component
{
    public ?string $contractId = null;
    public int $step = 1; // 1: General Terms, 2: Financial Details, 3: Admin Notes

    // General Terms
    public string $boarding_house_id = '';
    public string $room_id = '';
    public string $resident_id = '';
    public string $contract_type = 'monthly';
    public string $start_date = '';
    public string $end_date = '';
    public string $move_in_date = '';
    public int $duration_months = 1;
    public bool $auto_renewal = false;

    // Financial Details
    public float $monthly_rent = 0.00;
    public float $security_deposit = 0.00;
    public float $electricity_fee = 0.00;
    public float $water_fee = 0.00;
    public float $internet_fee = 0.00;
    public float $parking_fee = 0.00;
    public float $additional_charges = 0.00;
    public float $discount = 0.00;

    // Administrative
    public string $internal_notes = '';
    public string $public_notes = '';

    public function mount(?string $id = null): void
    {
        $this->contractId = $id;

        if ($id) {
            $contract = Contract::findOrFail($id);

            if (Auth::user()->cannot('view', $contract)) {
                abort(403, 'Unauthorized.');
            }

            $this->boarding_house_id = $contract->boarding_house_id;
            $this->room_id = $contract->room_id ?? '';
            $this->resident_id = $contract->resident_id;
            $this->contract_type = $contract->contract_type->value;
            $this->start_date = $contract->start_date->format('Y-m-d');
            $this->end_date = $contract->end_date->format('Y-m-d');
            $this->move_in_date = $contract->move_in_date->format('Y-m-d');
            $this->duration_months = $contract->duration_months;
            $this->auto_renewal = $contract->auto_renewal;

            $this->monthly_rent = (float) $contract->monthly_rent;
            $this->security_deposit = (float) $contract->security_deposit;
            $this->electricity_fee = (float) $contract->electricity_fee;
            $this->water_fee = (float) $contract->water_fee;
            $this->internet_fee = (float) $contract->internet_fee;
            $this->parking_fee = (float) $contract->parking_fee;
            $this->additional_charges = (float) $contract->additional_charges;
            $this->discount = (float) $contract->discount;

            $this->internal_notes = $contract->internal_notes ?? '';
            $this->public_notes = $contract->public_notes ?? '';
        } else {
            if (Auth::user()->cannot('create', Contract::class)) {
                abort(403, 'Unauthorized.');
            }
            $this->start_date = date('Y-m-d');
            $this->move_in_date = date('Y-m-d');
            $this->end_date = date('Y-m-d', strtotime('+1 month'));

            // Set default Boarding House selection
            $firstHouse = BoardingHouse::first();
            if ($firstHouse) {
                $this->boarding_house_id = $firstHouse->id;
            }
        }
    }

    public function updatedBoardingHouseId(): void
    {
        $this->room_id = '';
    }

    public function updatedRoomId(): void
    {
        if ($this->room_id) {
            $room = Room::find($this->room_id);
            if ($room) {
                $this->monthly_rent = (float) $room->monthly_rent;
                $this->security_deposit = (float) $room->security_deposit;
            }
        }
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'boarding_house_id' => ['required', 'uuid', 'exists:boarding_houses,id'],
                'room_id' => ['required', 'uuid', 'exists:rooms,id'],
                'resident_id' => ['required', 'uuid', 'exists:residents,id'],
                'contract_type' => ['required', 'string', 'in:monthly,quarterly,semi_annual,annual,custom'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after:start_date'],
                'move_in_date' => ['required', 'date'],
                'duration_months' => ['required', 'integer', 'min:1'],
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'monthly_rent' => ['required', 'numeric', 'min:0'],
                'security_deposit' => ['required', 'numeric', 'min:0'],
                'electricity_fee' => ['required', 'numeric', 'min:0'],
                'water_fee' => ['required', 'numeric', 'min:0'],
                'internet_fee' => ['required', 'numeric', 'min:0'],
                'parking_fee' => ['required', 'numeric', 'min:0'],
                'additional_charges' => ['required', 'numeric', 'min:0'],
                'discount' => ['required', 'numeric', 'min:0', 'max:monthly_rent'],
            ]);
        }

        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step--;
    }

    public function saveContract(ContractService $service): void
    {
        $this->validate([
            'internal_notes' => ['nullable', 'string', 'max:1000'],
            'public_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $data = [
            'tenant_id' => tenant()->id,
            'boarding_house_id' => $this->boarding_house_id,
            'room_id' => $this->room_id,
            'resident_id' => $this->resident_id,
            'contract_type' => $this->contract_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'move_in_date' => $this->move_in_date,
            'duration_months' => $this->duration_months,
            'auto_renewal' => $this->auto_renewal,
            'monthly_rent' => $this->monthly_rent,
            'security_deposit' => $this->security_deposit,
            'electricity_fee' => $this->electricity_fee,
            'water_fee' => $this->water_fee,
            'internet_fee' => $this->internet_fee,
            'parking_fee' => $this->parking_fee,
            'additional_charges' => $this->additional_charges,
            'discount' => $this->discount,
            'internal_notes' => $this->internal_notes,
            'public_notes' => $this->public_notes,
        ];

        try {
            if ($this->contractId) {
                $contract = Contract::findOrFail($this->contractId);

                if (Auth::user()->cannot('update', $contract)) {
                    abort(403, 'Unauthorized.');
                }

                $service->updateContract($contract, $data);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Lease contract specifications modified.']);
            } else {
                if (Auth::user()->cannot('create', Contract::class)) {
                    abort(403, 'Unauthorized.');
                }
                $contract = $service->createContract($data);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Lease agreement draft created! Proceed to generate signed files.']);
            }

            $this->redirect(route('contracts.show', $contract->id));
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $boardingHouses = BoardingHouse::all();
        $residents = Resident::orderBy('name')->get();

        // Load available rooms or room currently assigned to this contract
        $availableRooms = Room::where('boarding_house_id', $this->boarding_house_id)
            ->where(function($q) {
                $q->where('status', 'available')
                  ->orWhere('id', $this->room_id);
            })
            ->orderBy('room_number')
            ->get();

        return view('livewire.contract.contract-form', [
            'boardingHouses' => $boardingHouses,
            'residents' => $residents,
            'availableRooms' => $availableRooms,
        ])->layout('layouts.app');
    }
}
