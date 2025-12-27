<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->paginate(10);
        return view('admin.verification.index', compact('pendingUsers'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'verified']);
        return back()->with('success', 'Warga berhasil diverifikasi.');
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);
        return back()->with('error', 'Warga ditolak.');
    }
}
