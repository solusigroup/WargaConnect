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
        // Check if there is a pending payment
        $payment = $bill->payments()->where('status', 'pending')->latest()->first();
        return view('resident.bills.show', compact('bill', 'payment'));
    }

    public function pay(Request $request, Bill $bill)
    {
        // Debugging: Check Server Key (Do not log the full key in production)
        if (empty(\Midtrans\Config::$serverKey)) {
            \Illuminate\Support\Facades\Log::error('Midtrans Server Key is missing for bill ID: ' . $bill->id);
            return redirect()->back()->with('error', 'Konfigurasi pembayaran bermasalah (Server Key Missing).');
        }

        // Prevent duplicate pending payments
        $existingPayment = $bill->payments()->where('status', 'pending')->first();
        if ($existingPayment) {
            return redirect()->route('bill.show', $bill)->with('error', 'Anda sudah memiliki pembayaran tertunda.');
        }

        $transactionId = 'TRX-' . time() . '-' . $bill->id;
        $amount = $bill->amount;

        $payment = Payment::create([
            'bill_id' => $bill->id,
            'amount' => $amount,
            'method' => 'qris', // Default to QRIS/Midtrans handling
            'status' => 'pending',
            'transaction_id' => $transactionId,
        ]);

        // Midtrans Params
        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $bill->user->name,
                'email' => $bill->user->email,
                'phone' => $bill->user->warga->no_hp ?? '08123456789',
            ],
            'item_details' => [
                [
                    'id' => 'BILL-' . $bill->id,
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => 'Iuran ' . $bill->kategoriIuran->nama_iuran . ' ' . $bill->month_name,
                ]
            ],
        ];

        try {
            \Illuminate\Support\Facades\Log::info('Initiating Midtrans Payment for TRX: ' . $transactionId);
            
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $payment->update(['snap_token' => $snapToken]);
            
            return redirect()->back()->with('success', 'Silakan selesaikan pembayaran.')->with('snap_token', $snapToken);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Error for TRX ' . $transactionId . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed == $request->signature_key) {
            $transactionStatus = $request->transaction_status;
            $orderId = $request->order_id;
            
            $payment = Payment::where('transaction_id', $orderId)->firstOrFail();
            $bill = $payment->bill;

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $payment->update(['status' => 'success', 'paid_at' => now()]);
                $bill->update(['status' => 'paid']);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $payment->update(['status' => 'failed']);
                // Logic to reset bill status if needed, but 'unpaid' is default so ok.
            }
        }
        return response()->json(['status' => 'ok']);
    }
}
