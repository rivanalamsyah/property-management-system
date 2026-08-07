<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentTimeline;
use App\Models\User;
use App\Models\Tenant;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::where('slug', 'cihampelas')->first();
        tenant_manager()->setTenant($tenant);

        $staff = User::where('email', 'staff@example.test')->first();

        // Query all invoices in DB
        $invoices = Invoice::where('tenant_id', $tenant->id)->get();

        foreach ($invoices as $inv) {
            // Only seed payments for paid invoices
            if ($inv->status !== InvoiceStatus::PAID) {
                continue;
            }

            $payment = Payment::firstOrCreate(
                ['tenant_id' => $tenant->id, 'invoice_id' => $inv->id],
                [
                    'contract_id'           => $inv->contract_id,
                    'resident_id'           => $inv->resident_id,
                    'boarding_house_id'     => $inv->boarding_house_id,
                    'transaction_number'    => 'TX-' . str_replace('INV-', '', $inv->invoice_number),
                    'reference_number'      => 'REF-' . rand(100000000, 999999999),
                    'payment_date'          => $inv->invoice_date->copy()->addDays(1),
                    'payment_method'        => 'bank_transfer',
                    'amount_paid'           => $inv->grand_total,
                    'admin_fee'             => 0.00,
                    'penalty_paid'          => 0.00,
                    'proof_of_payment_path' => 'receipts/dummy_receipt.jpg',
                    'status'                => 'completed',
                    'verified_by'           => $staff?->id,
                    'verified_at'           => $inv->invoice_date->copy()->addDays(1),
                ]
            );

            PaymentTimeline::create([
                'payment_id'  => $payment->id,
                'event'       => 'proof_uploaded',
                'title'       => 'Bukti Pembayaran Dikirim',
                'description' => "Bukti transfer sebesar Rp" . number_format($inv->grand_total, 0, ',', '.') . " telah dikirim oleh penghuni.",
                'created_at'  => $inv->invoice_date->copy()->addDays(1),
            ]);

            PaymentTimeline::create([
                'payment_id'  => $payment->id,
                'event'       => 'completed',
                'title'       => 'Pembayaran Diverifikasi',
                'description' => "Pembayaran diverifikasi oleh Staf " . ($staff?->name ?? '') . " dan tagihan dilunasi.",
                'created_at'  => $inv->invoice_date->copy()->addDays(1),
            ]);
        }

        tenant_manager()->setTenant(null);
    }
}
