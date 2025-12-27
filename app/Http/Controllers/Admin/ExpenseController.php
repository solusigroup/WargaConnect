<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Pengeluaran::latest()->paginate(10);
        return view('admin.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal_pengeluaran' => 'required|date',
            'bukti_foto' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->only(['judul', 'deskripsi', 'nominal', 'tanggal_pengeluaran']);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('bukti_foto')) {
            $path = $request->file('bukti_foto')->store('expenses', 'public');
            $data['bukti_foto'] = $path;
        }

        Pengeluaran::create($data);

        return redirect()->route('admin.expenses.index')->with('success', 'Data pengeluaran berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengeluaran $expense)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal_pengeluaran' => 'required|date',
            'bukti_foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'nominal', 'tanggal_pengeluaran']);

        if ($request->hasFile('bukti_foto')) {
            // Delete old photo
            if ($expense->bukti_foto) {
                Storage::disk('public')->delete($expense->bukti_foto);
            }
            $path = $request->file('bukti_foto')->store('expenses', 'public');
            $data['bukti_foto'] = $path;
        }

        $expense->update($data);

        return redirect()->route('admin.expenses.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengeluaran $expense)
    {
        if ($expense->bukti_foto) {
            Storage::disk('public')->delete($expense->bukti_foto);
        }
        $expense->delete();

        return redirect()->route('admin.expenses.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
