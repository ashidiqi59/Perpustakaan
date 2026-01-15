<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Command;

class CheckOverdueLoans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:check-overdue {--all : Check all overdue loans including returned late}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update overdue loan status';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $all = $this->option('all');
        
        // Update loans that are overdue (not returned and due_date has passed)
        $overdueNotReturned = Loan::where('status', Loan::STATUS_PEMINJAMAN)
            ->where('due_date', '<', now()->toDateString())
            ->whereNull('return_date')
            ->update(['status' => Loan::STATUS_TERLAMBAT]);

        if ($overdueNotReturned > 0) {
            $this->info("Updated {$overdueNotReturned} loans as overdue (not returned)");
        } else {
            $this->info("No overdue loans found that are not returned");
        }

        // Optionally update loans that were returned late
        if ($all) {
            $returnedLate = Loan::where('status', Loan::STATUS_DIKEMBALIKAN)
                ->whereNotNull('return_date')
                ->where('return_date', '>', now()->toDateString())
                ->update(['status' => Loan::STATUS_TERLAMBAT]);

            if ($returnedLate > 0) {
                $this->info("Updated {$returnedLate} loans as overdue (returned late)");
            }
        }

        $this->info('Overdue check completed!');
        return Command::SUCCESS;
    }
}

