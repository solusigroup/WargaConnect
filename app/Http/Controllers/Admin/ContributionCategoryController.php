<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriIuran;
use Illuminate\Http\Request;

class ContributionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = KategoriIuran::all();
        return view('admin.contribution_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contribution_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'is_mandatory' => 'boolean',
        ]);

        KategoriIuran::create([
            'nama_iuran' => $request->nama_iuran,
            'nominal' => $request->nominal,
            'is_mandatory' => $request->is_mandatory ?? false,
            'is_active' => true,
        ]);

        return redirect()->route('admin.contribution-categories.index')->with('success', 'Kategori iuran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriIuran $contributionCategory)
    {
        return view('admin.contribution_categories.edit', compact('contributionCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriIuran $contributionCategory)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'is_mandatory' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $contributionCategory->update([
            'nama_iuran' => $request->nama_iuran,
            'nominal' => $request->nominal,
            'is_mandatory' => $request->is_mandatory ?? false,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.contribution-categories.index')->with('success', 'Kategori iuran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriIuran $contributionCategory)
    {
        $contributionCategory->delete();
        return redirect()->route('admin.contribution-categories.index')->with('success', 'Kategori iuran berhasil dihapus.');
    }
}
