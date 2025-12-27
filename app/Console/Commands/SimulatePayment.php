<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SimulatePayment extends Command
{
    protected $signature = 'app:simulate-payment';
    protected $description = 'Simulate a payment for Warga 1';

    public function handle()
    {
        $user = \App\Models\User::where('email', 'warga1@rt35.warga')->first();
        if (!$user) {
            $this->error('User not found');
            return;
        }

        $bill = $user->bills()->where('status', 'unpaid')->first();
        if (!$bill) {
            $this->info('No unpaid bills found. Creating one...');
            $category = \App\Models\KategoriIuran::first();
            if (!$category) {
                 $category = \App\Models\KategoriIuran::create([
                    'nama_iuran' => 'Iuran Sampah', 'nominal' => 15000, 
                    'is_mandatory' => true, 'frequency' => 'monthly'
                 ]);
            }
            $bill = \App\Models\Bill::create([
                'user_id' => $user->id,
                'kategori_iuran_id' => $category->id,
                'month' => now()->month,
                'year' => now()->year,
                'amount' => $category->nominal,
                'status' => 'unpaid',
                'due_date' => now()->addDays(5)
            ]);
        }

        $this->info("Found Bill: {$bill->id} Amount: {$bill->amount}");

        $payment = \App\Models\Payment::create([
            'bill_id' => $bill->id,
            'amount' => $bill->amount,
            'method' => 'qris',
            'status' => 'pending',
            'transaction_id' => 'SIM-' . time(),
            'snap_token' => 'sim-token-' . time(),
        ]);
        
        $this->info("Created Payment: {$payment->id}");

        // Simulate Success
        $payment->update(['status' => 'success', 'paid_at' => now()]);
        $bill->update(['status' => 'paid']);

        $this->info("Payment Success. Bill Status: " . $bill->fresh()->status);
    }
}
