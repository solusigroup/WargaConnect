<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\KategoriIuran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillGenerationController extends Controller
{
    public function create()
    {
        $categories = KategoriIuran::where('is_active', true)->get();
        return view('admin.bills.generate', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:'.(date('Y')+1),
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:kategori_iuran,id',
        ]);

        $month = $request->month;
        $year = $request->year;
        $categoryIds = $request->categories;
        
        $residents = User::where('role', 'warga')->where('status', 'verified')->get();
        $categories = KategoriIuran::whereIn('id', $categoryIds)->get();

        $count = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {
            foreach ($residents as $resident) {
                foreach ($categories as $category) {
                    // Check if bill already exists
                    $exists = Bill::where('user_id', $resident->id)
                        ->where('kategori_iuran_id', $category->id)
                        ->where('month', $month)
                        ->where('year', $year)
                        ->exists();

                    if (!$exists) {
                        Bill::create([
                            'user_id' => $resident->id,
                            'kategori_iuran_id' => $category->id,
                            'month' => $month,
                            'year' => $year,
                            'amount' => $category->nominal,
                            'status' => 'unpaid',
                            'due_date' => Carbon::createFromDate($year, $month, 10)->format('Y-m-d'), // Due date on 10th
                        ]);
                        $count++;
                    } else {
                        $skipped++;
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat generate tagihan: ' . $e->getMessage());
        }

        return redirect()->route('admin.bills.generate')->with('success', "Berhasil membuat $count tagihan. ($skipped dilewati karena sudah ada).");
    }
}
