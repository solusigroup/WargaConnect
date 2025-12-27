<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    /**
     * Display the financial report.
     */
    public function index()
    {
        // 1. Total Pemasukan (Paid Bills)
        $totalIncome = Payment::where('status', 'paid')->sum('amount'); // Assuming Payment has 'amount' and 'status'

        // Note: Currently Payment model might rely on Bill amount. 
        // If Payment table structure is simple (id, bill_id, amount, status), check schema.
        // Assuming Payment status is 'paid' or 'verified'.
        // Let's check Payment migration in next step to be sure about status column.
        // For now, assume Payment table stores the actual paid amount.
        
        // 2. Total Pengeluaran
        $totalExpense = Pengeluaran::sum('nominal');

        // 3. Saldo
        $balance = $totalIncome - $totalExpense;

        // 4. Mutation List (Income & Expense merged)
        $incomes = Payment::with('bill.user')
            ->where('status', 'paid') // or 'verified'
            ->latest()
            ->get() // Chunking might be needed for large data, but ok for now.
            ->map(function ($payment) {
                return [
                    'type' => 'income',
                    'date' => $payment->created_at, // or payment_date
                    'title' => 'Pembayaran Tagihan - ' . ($payment->bill->user->name ?? 'Warga'),
                    'nominal' => $payment->amount,
                    'description' => 'Iuran ' . ($payment->bill->kategoriIuran->nama_iuran ?? '') . ' ' . $payment->bill->month_name . ' ' . $payment->bill->year,
                ];
            });

        $expenses = Pengeluaran::latest()
            ->get()
            ->map(function ($expense) {
                return [
                    'type' => 'expense',
                    'date' => $expense->tanggal_pengeluaran,
                    'title' => $expense->judul,
                    'nominal' => $expense->nominal,
                    'description' => $expense->deskripsi,
                ];
            });

        $mutations = $incomes->merge($expenses)->sortByDesc('date');

        return view('reports.financial', compact('totalIncome', 'totalExpense', 'balance', 'mutations'));
    }
}
