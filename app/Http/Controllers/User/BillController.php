<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all bills ordered by due date/month
        $bills = $user->bills()
            ->with('kategoriIuran')
            ->latest()
            ->paginate(10);

        return view('user.bills.index', compact('bills'));
    }

    public function show(\App\Models\Bill $bill)
    {
        // Ensure user owns the bill or is admin
        if ($bill->user_id !== Auth::id() && strtolower(Auth::user()->role) !== 'admin') {
            abort(403);
        }

        // Check if there is a pending payment (manual or other)
        $payment = $bill->payments()->where('status', 'pending')->latest()->first();
        
        return view('resident.bills.show', compact('bill', 'payment'));
    }
}
