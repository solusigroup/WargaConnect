<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id',
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $bill = Bill::findOrFail($request->tagihan_id);

        if ($bill->status === 'paid') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        Payment::create([
            'bill_id' => $bill->id,
            'amount' => $bill->amount,
            'method' => 'manual_transfer', // or 'manual_cash' if logic differs
            'status' => 'pending',
            'bukti_pembayaran' => $path,
            'transaction_id' => 'MAN-' . time() . '-' . $bill->id,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi bendahara.');
    }
}
