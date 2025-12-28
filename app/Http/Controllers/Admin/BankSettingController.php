<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSetting;
use Illuminate\Http\Request;

class BankSettingController extends Controller
{
    public function index()
    {
        $settings = BankSetting::all();
        // Assume usually one record for now, or multiple if needed. 
        // If single record singleton pattern, logic differs. 
        // Using collection for now.
        
        // For simplicity, let's treat it as managing the FIRST record or creating one if empty.
        $setting = BankSetting::first();
        
        return view('admin.bank-settings.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_holder' => 'required|string',
            'dana_number' => 'required|string',
        ]);

        $setting = BankSetting::first();
        if ($setting) {
            $setting->update($validated);
        } else {
            BankSetting::create($validated);
        }

        return back()->with('success', 'Pengaturan bank berhasil disimpan.');
    }
}
