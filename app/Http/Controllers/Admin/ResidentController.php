<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'warga')->where('status', 'verified');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('warga', function($w) use ($search) {
                      $w->where('nik', 'like', "%{$search}%")
                        ->orWhere('alamat_rumah', 'like', "%{$search}%");
                  });
            });
        }

        $residents = $query->with('warga')->latest()->paginate(10);

        return view('admin.residents.index', compact('residents'));
    }

    public function show(User $resident)
    {
        if ($resident->role !== 'warga') {
            abort(404);
        }
        
        $resident->load(['warga.anggotaKeluarga', 'bills.payment']);
        
        return view('admin.residents.show', compact('resident'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil direset.');
    }
}
