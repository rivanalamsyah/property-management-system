<?php

namespace App\Livewire;

use App\Enums\ComplaintStatus;
use App\Enums\PaymentStatus;
use App\Enums\ResidentStatus;
use App\Models\ActivityLog;
use App\Models\BoardingHouse;
use App\Models\Complaint;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Room;
use App\Models\InAppNotification;
use App\Services\ComplaintService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    // Resident Tabs
    public string $activeResidentTab = 'room';

    // Resident check-out
    public bool $showCheckOutModal = false;

    // Resident new complaint
    public bool $showComplaintModal = false;
    public string $complaintTitle = '';
    public string $complaintDescription = '';
    public string $complaintCategory = 'general';

    // Resident post comment
    public string $newCommentText = '';
    public ?string $activeComplaintId = null;

    // Resident upload payment proof
    public bool $showPaymentModal = false;
    public ?string $paymentInvoiceId = null;
    public string $paymentReferenceNumber = '';
    public $paymentProofFile = null;

    public function triggerTestToast(string $type): void
    {
        $messages = [
            'success' => 'Sukses! Koneksi database terverifikasi dan ruang kerja disinkronkan.',
            'error' => 'Error! Tindakan tidak dapat diproses karena kendala validasi.',
            'warning' => 'Peringatan! Pemeliharaan sistem terjadwal dimulai pukul 12:00 AM UTC.',
            'info' => 'Info! Sistem notifikasi baru telah diinisialisasi sepenuhnya.',
        ];

        $this->dispatch('toast', [
            'type' => $type,
            'message' => $messages[$type] ?? 'Notifikasi dipicu.',
        ]);
    }

    public function submitCheckOut(string $contractId): void
    {
        $resident = Auth::user()->resident();
        if (!$resident) {
            return;
        }

        try {
            $resident->update(['status' => ResidentStatus::MOVING_OUT]);

            // Track timeline
            $residentTimeline = new \App\Services\ResidentService();
            $residentTimeline->updateResident($resident, [
                'status' => ResidentStatus::MOVING_OUT->value,
            ]);

            $this->showCheckOutModal = false;
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Permintaan check-out telah terdaftar. Manajemen akan segera memeriksa kamar.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function submitComplaint(ComplaintService $service): void
    {
        $resident = Auth::user()->resident();
        if (!$resident) {
            return;
        }

        $this->validate([
            'complaintTitle' => ['required', 'string', 'max:150'],
            'complaintDescription' => ['required', 'string', 'max:2000'],
            'complaintCategory' => ['required', 'string', 'in:general,plumbing,electrical,structural,furniture,appliance,internet,other'],
        ]);

        try {
            $year = date('Y');
            $count = Complaint::where('tenant_id', tenant()->id)->whereYear('created_at', $year)->count();
            $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            $complaintNumber = "CMP-{$year}-{$sequence}";

            $service->createComplaint([
                'tenant_id' => tenant()->id,
                'boarding_house_id' => $resident->boarding_house_id,
                'room_id' => $resident->room_id,
                'resident_id' => $resident->id,
                'complaint_number' => $complaintNumber,
                'subject' => $this->complaintTitle,
                'description' => $this->complaintDescription,
                'category' => $this->complaintCategory,
                'status' => ComplaintStatus::OPEN,
            ]);

            $this->showComplaintModal = false;
            $this->reset(['complaintTitle', 'complaintDescription', 'complaintCategory']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Tiket keluhan berhasil didaftarkan.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function openPaymentModal(string $invoiceId): void
    {
        $this->paymentInvoiceId = $invoiceId;
        $this->showPaymentModal = true;
    }

    public function uploadPaymentProof(PaymentService $service): void
    {
        $resident = Auth::user()->resident();
        if (!$resident || !$this->paymentInvoiceId) {
            return;
        }

        $this->validate([
            'paymentReferenceNumber' => ['required', 'string', 'max:50'],
            'paymentProofFile' => ['required', 'file', 'image', 'max:5120'], // Max 5MB image
        ]);

        try {
            $invoice = Invoice::findOrFail($this->paymentInvoiceId);

            $path = $this->paymentProofFile->store('payments', 'public');

            $year = date('Y');
            $count = Payment::where('tenant_id', tenant()->id)->whereYear('created_at', $year)->count();
            $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            $paymentNumber = "PAY-{$year}-{$sequence}";

            $service->initiatePayment([
                'invoice_id' => $invoice->id,
                'payment_number' => $paymentNumber,
                'amount_paid' => $invoice->grand_total,
                'payment_date' => now()->format('Y-m-d H:i:s'),
                'payment_method' => 'bank_transfer',
                'status' => PaymentStatus::WAITING_VERIFICATION,
                'reference_number' => $this->paymentReferenceNumber,
                'attachment_path' => $path,
            ]);

            $this->showPaymentModal = false;
            $this->reset(['paymentInvoiceId', 'paymentReferenceNumber', 'paymentProofFile']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Bukti transfer pembayaran berhasil diunggah. Staf akan memverifikasi transaksi.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function postComment(string $complaintId, ComplaintService $service): void
    {
        $resident = Auth::user()->resident();
        if (!$resident) {
            return;
        }

        $this->validate([
            'newCommentText' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $complaint = Complaint::findOrFail($complaintId);

            $service->addComment($complaint, [
                'resident_id' => $resident->id,
                'comment' => $this->newCommentText,
                'is_tenant_visible' => true,
            ]);

            $this->reset(['newCommentText']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Komentar berhasil diposting di papan diskusi.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function switchResidentTab(string $tab): void
    {
        $this->activeResidentTab = $tab;
    }

    public function render()
    {
        $user = Auth::user();
        $tenant = tenant();

        if ($user->hasRole('tenant')) {
            $resident = $user->resident();

            if (!$resident) {
                return view('livewire.resident-dashboard-empty')
                    ->layout('layouts.app');
            }

            // Fetch resident portal data arrays
            $contracts = Contract::where('resident_id', $resident->id)->latest()->get();
            $activeContract = $contracts->firstWhere('status', \App\Enums\ContractStatus::ACTIVE);
            
            $invoices = Invoice::where('resident_id', $resident->id)->latest()->take(10)->get();
            $payments = Payment::where('resident_id', $resident->id)->latest()->take(10)->get();
            $complaints = Complaint::with(['comments.user', 'comments.resident', 'timeline', 'maintenanceTask.checklists'])
                ->where('resident_id', $resident->id)
                ->latest()
                ->take(10)
                ->get();

            $notifications = InAppNotification::where('resident_id', $resident->id)
                ->latest()
                ->take(10)
                ->get();

            return view('livewire.resident-dashboard', [
                'resident' => $resident,
                'activeContract' => $activeContract,
                'contracts' => $contracts,
                'invoices' => $invoices,
                'payments' => $payments,
                'complaints' => $complaints,
                'notifications' => $notifications,
            ])->layout('layouts.app');
        }

        // Standard Admin/Landlord logs & stats
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
        
        $currentMonthRevenue = Payment::where('status', PaymentStatus::COMPLETED)
            ->whereMonth('payment_date', date('m'))
            ->whereYear('payment_date', date('Y'))
            ->sum('amount_paid');

        $pendingComplaintsCount = Complaint::whereIn('status', [
            ComplaintStatus::OPEN,
            ComplaintStatus::ASSIGNED,
            ComplaintStatus::IN_PROGRESS
        ])->count();

        $activities = ActivityLog::where('tenant_id', $tenant ? $tenant->id : null)
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.dashboard', [
            'activities' => $activities,
            'tenant' => $tenant,
            'totalRooms' => $totalRooms,
            'occupancyRate' => $occupancyRate,
            'occupiedRooms' => $occupiedRooms,
            'currentMonthRevenue' => $currentMonthRevenue,
            'pendingComplaintsCount' => $pendingComplaintsCount,
        ])->layout('layouts.app');
    }
}
