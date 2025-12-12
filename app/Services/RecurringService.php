<?php
namespace App\Services;

use App\Models\Transaction;
use App\Repositories\RecurringTransactionRepository;
use Carbon\Carbon;
use App\Models\RecurringTransaction;
class RecurringService
{
    protected RecurringTransactionRepository $repo;

    public function __construct()
    {
        $this->repo = new RecurringTransactionRepository();
    }

    public function generateDueRecurring(): array
    {
        $dueItems = $this->repo->getDueRecurring();
        $results = [];

        $adapter = new \App\Adapters\RecurringTransactionAdapter();

        foreach ($dueItems as $rec) {

            $tx = Transaction::create(
                $adapter->transform($rec)
            );

            $this->repo->updateNextRun($rec);

            $results[] = $tx;
        }

        return $results;
    }


    public function createRecurring(array $data)
{
    $period = $data['recurrence_period'];

    $next = match ($period) {
        'daily'   => now()->addDay(),
        'weekly'  => now()->addWeek(),
        'monthly' => now()->addMonth(),
        default   => now(), 
    };

    return RecurringTransaction::create([
        'user_id'             => $data['user_id'],
        'category_id'         => $data['category_id'],
        'amount'              => $data['amount'],
        'type'                => $data['type'],
        'description'         => $data['description'] ?? null,
        'recurrence_period'   => $period,
        'next_execution_date' => $next,
        'last_execution_date' => null,
    ]);
}
}
