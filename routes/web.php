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
})->middleware(['auth', 'verified_user'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment & Bills
    Route::get('/bills', [App\Http\Controllers\User\BillController::class, 'index'])->name('bills.index');
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

        // Resident Database
        Route::resource('residents', App\Http\Controllers\Admin\ResidentController::class)->only(['index', 'show']);
        // Reports
        Route::get('/reports/monthly', [App\Http\Controllers\Admin\Reports\MonthlyContributionController::class, 'index'])->name('reports.monthly');
    });

    // Financial Reports (Accessible to all verified users)
    Route::get('/finance', [App\Http\Controllers\FinancialReportController::class, 'index'])->name('finance.index');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    // Complaints / Aduan
    Route::resource('complaints', App\Http\Controllers\ComplaintController::class);

    Route::get('/verification/notice', function () {
        return view('auth.verify-notice'); // You need to create this view
    })->name('verification.notice');
});

// Midtrans Callback (Outside Auth)
Route::post('/midtrans/callback', [App\Http\Controllers\PaymentController::class, 'callback'])->name('midtrans.callback');

require __DIR__.'/auth.php';
