<?php
namespace App\Repositories;

use App\Models\RecurringTransaction;
use Carbon\Carbon;

class RecurringTransactionRepository
{
    public function getDueRecurring()
    {
        return RecurringTransaction::where('next_execution_date', '<=', Carbon::now())->get();
    }

    public function updateNextRun(RecurringTransaction $rt)
    {
        $interval = $rt->recurrence_period;

        $rt->last_execution_date = Carbon::now()->toDateString();

        $rt->next_execution_date = match ($interval) {
            'daily'   => Carbon::now()->addDay()->toDateString(),
            'weekly'  => Carbon::now()->addWeek()->toDateString(),
            'monthly' => Carbon::now()->addMonth()->toDateString(),
            default   => Carbon::now()->addMonth()->toDateString(),
        };

        $rt->save();
    }
}
