<?php

namespace App\Commands;

use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Carbon\Carbon;

class GenerateRecurringTransactionCommand implements CommandInterface
{
    public function execute(): void
    {
        $recurrings = RecurringTransaction::all();
        $adapter = new \App\Adapters\RecurringTransactionAdapter();

        foreach ($recurrings as $rec) {

            if (!$this->shouldGenerate($rec)) {
                continue;
            }

            Transaction::create(
                $adapter->transform($rec)
            );

            $rec->last_execution_date = Carbon::now();
            $rec->next_execution_date = $this->calculateNextDate($rec);
            $rec->save();
        }
    }


    private function shouldGenerate(RecurringTransaction $rec): bool
    {
        if ($rec->last_execution_date === null) {
            return Carbon::now()->greaterThanOrEqualTo($rec->next_execution_date);
        }

        return Carbon::now()->greaterThanOrEqualTo($rec->next_execution_date);
    }

    private function calculateNextDate(RecurringTransaction $rec): string
    {
        return match ($rec->recurrence_period) {
            'daily'   => Carbon::now()->addDay(),
            'weekly'  => Carbon::now()->addWeek(),
            'monthly' => Carbon::now()->addMonth(),
        };
    }
}
