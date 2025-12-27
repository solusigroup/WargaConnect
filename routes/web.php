<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $recentPayments = \App\Models\Payment::whereHas('bill', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->latest()->take(5)->get();
    
    $unpaidBills = $user->bills()->whereIn('status', ['unpaid', 'arrears'])->get();
    $totalArrears = $unpaidBills->sum('amount');
    $unpaidBill = $unpaidBills->sortBy('year')->sortBy('month')->first();

    return view('dashboard', compact('recentPayments', 'unpaidBill', 'totalArrears'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment & Bills
    Route::get('/bill/{bill}', [App\Http\Controllers\PaymentController::class, 'show'])->name('bill.show');
    Route::post('/bill/{bill}/pay', [App\Http\Controllers\PaymentController::class, 'pay'])->name('bill.pay');

    // Admin Routes
    Route::middleware(['verified_user'])->prefix('admin')->name('admin.')->group(function () {
        // Announcements
        Route::resource('announcements', App\Http\Controllers\AnnouncementController::class)->only(['index', 'store', 'destroy']);
        
        // User Verification
        Route::get('/verification', [App\Http\Controllers\Admin\UserVerificationController::class, 'index'])->name('verification.index');
        Route::post('/verification/{user}/approve', [App\Http\Controllers\Admin\UserVerificationController::class, 'approve'])->name('verification.approve');
        Route::post('/verification/{user}/reject', [App\Http\Controllers\Admin\UserVerificationController::class, 'reject'])->name('verification.reject');

        // Contribution Categories
        Route::resource('contribution-categories', App\Http\Controllers\Admin\ContributionCategoryController::class);

        // Expenses
        Route::resource('expenses', App\Http\Controllers\Admin\ExpenseController::class);
    });

    // Financial Reports (Accessible to all verified users)
    Route::get('/finance', [App\Http\Controllers\FinancialReportController::class, 'index'])->name('finance.index');

    Route::get('/verification/notice', function () {
        return view('auth.verify-notice'); // You need to create this view
    })->name('verification.notice');
});

require __DIR__.'/auth.php';
