<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\ContributionCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wargaconnect:generate-bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly bills for verified residents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting bill generation...');

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $dueDate = Carbon::now()->addDays(10); // Due date is 10th of the month, or 10 days from now

        $verifiedUsers = User::verified()->get();
        $categories = ContributionCategory::where('is_mandatory', true)->get();

        if ($categories->isEmpty()) {
            $this->error('No mandatory contribution categories found.');
            return;
        }

        $count = 0;

        foreach ($verifiedUsers as $user) {
            foreach ($categories as $category) {
                // Check if bill already exists
                $exists = Bill::where('user_id', $user->id)
                    ->where('contribution_category_id', $category->id)
                    ->where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->exists();

                if (!$exists) {
                    Bill::create([
                        'user_id' => $user->id,
                        'contribution_category_id' => $category->id,
                        'month' => $currentMonth,
                        'year' => $currentYear,
                        'amount' => $category->amount,
                        'status' => 'unpaid',
                        'due_date' => $dueDate,
                    ]);
                    $count++;
                }
            }
        }

        $this->info("Generated {$count} bills for " . $verifiedUsers->count() . " residents.");
    }
}
