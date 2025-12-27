<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nik' => ['required', 'string', 'max:16', 'unique:wargas'],
            'no_kk' => ['required', 'string', 'max:16'],
            'tempat_lahir' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat_rumah' => ['required', 'string'],
            'house_number' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'family_members' => ['nullable', 'array'],
            'family_members.*.nama_lengkap' => ['required', 'string'],
            'family_members.*.nik' => ['required', 'string', 'max:16', 'distinct', 'unique:anggota_keluarga,nik'],
            'family_members.*.hubungan_keluarga' => ['required', 'string'],
            'family_members.*.tempat_lahir' => ['required', 'string'],
            'family_members.*.tanggal_lahir' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Combine Street Address with House Number if desired, or keep separate. 
            // The migration for wargas has `alamat_rumah` (text). 
            // I'll append house number to address for clarity or store simply.
            // Let's store: "Jalan Merpati No. 10"
            $fullAddress = $request->alamat_rumah . ' No. ' . $request->house_number;

            $warga = \App\Models\Warga::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->name,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat_rumah' => $fullAddress,
                'status_verifikasi' => 'pending',
            ]);

            if ($request->has('family_members')) {
                foreach ($request->family_members as $member) {
                    \App\Models\AnggotaKeluarga::create([
                        'warga_id' => $warga->id,
                        'nama_lengkap' => $member['nama_lengkap'],
                        'nik' => $member['nik'],
                        'hubungan_keluarga' => $member['hubungan_keluarga'],
                        'tempat_lahir' => $member['tempat_lahir'],
                        'tanggal_lahir' => $member['tanggal_lahir'],
                    ]);
                }
            }

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect(route('dashboard', absolute: false));
    }
}
