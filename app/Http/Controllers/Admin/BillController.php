<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function overrideLunas(Request $request, $bill_id) 
    {
        $bill = Bill::findOrFail($bill_id);
        
        // Simpan ke tabel pembayaran
        Payment::create([
            'bill_id' => $bill->id,
            'amount' => $bill->amount, // Updated from jumlah_bayar/nominal
            'method' => 'tunai', // metode_bayar cast to method
            'status' => 'success',
            'catatan_bendahara' => 'DI-OVERRIDE OLEH ADMIN: ' . $request->catatan,
            'paid_at' => now(), // tanggal_bayar cast to paid_at
            'is_override' => true,
        ]);
    
        // Update status tagihan
        $bill->update(['status' => 'paid']); // status_bayar cast to status
    
        return back()->with('success', 'Tagihan berhasil dilunasi via Override.');
    }
}
