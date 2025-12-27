<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function show(Bill $bill)
    {
        return view('resident.bills.show', compact('bill'));
    }

    public function pay(Request $request, Bill $bill)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,bank_transfer,cash',
        ]);

        // Map frontend values to database enum
        $methodMap = [
            'qris' => 'qris',
            'bank_transfer' => 'transfer',
            'cash' => 'cash',
        ];

        $payment = Payment::create([
            'bill_id' => $bill->id,
            'amount' => $bill->amount,
            'method' => $methodMap[$request->payment_method],
            'status' => 'pending',
            'transaction_id' => 'TRX-' . time() . '-' . $bill->id,
        ]);

        // return to the instruction page
        return view('resident.payments.show', compact('payment', 'bill'));
    }

    public function callback(Request $request)
    {
        // ... (Midtrans callback logic placeholder)
    }
}
