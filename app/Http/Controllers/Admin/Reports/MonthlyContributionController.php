<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\KategoriIuran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthlyContributionController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $categoryId = $request->input('category_id');

        // Fetch categories for filter
        $categories = KategoriIuran::all();

        // Base Query
        $query = Bill::with(['user.warga', 'kategoriIuran'])
            ->where('year', $year)
            ->where('month', $month);

        if ($categoryId) {
            $query->where('kategori_iuran_id', $categoryId);
        }

        $bills = $query->latest()->paginate(20)->withQueryString();

        // Summary Stats
        $stats = [
            'total_bills' => $query->count(),
            'paid_bills' => (clone $query)->where('status', 'paid')->count(),
            'unpaid_bills' => (clone $query)->whereIn('status', ['unpaid', 'arrears'])->count(),
            'collected_amount' => (clone $query)->where('status', 'paid')->sum('amount'),
            'pending_amount' => (clone $query)->whereIn('status', ['unpaid', 'arrears'])->sum('amount'),
        ];

        return view('admin.reports.monthly_contributions', compact('bills', 'categories', 'year', 'month', 'categoryId', 'stats'));
    }
}
