<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $pendingPayments = Payment::with(['bill.user', 'bill.kategoriIuran'])
            ->where('status', 'pending')
            ->whereNotNull('bukti_pembayaran')
            ->latest()
            ->paginate(10);

        return view('admin.payments.verification', compact('pendingPayments'));
    }

    public function confirm(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran ini sudah diproses.');
        }

        $payment->update([
            'status' => 'success',
            'paid_at' => now(),
            'catatan_bendahara' => 'Dikonfirmasi oleh Admin (' . \Illuminate\Support\Facades\Auth::user()->name . ')',
        ]);

        $payment->bill->update(['status' => 'paid']);

        // Logic to add to Cash Balance (Kas RT) should go here if you have a CashBalance/Mutation model
        // Example: CashMutation::addFromPayment($payment);

        return back()->with('success', 'Pembayaran dikonfirmasi lunas.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        $payment->update([
            'status' => 'failed', // or 'rejected'
            'catatan_bendahara' => $request->alasan,
        ]);

        // Bill remains unpaid or whatever logic applies

        return back()->with('success', 'Pembayaran ditolak.');
    }
}
