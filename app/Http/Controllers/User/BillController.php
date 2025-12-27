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
}
