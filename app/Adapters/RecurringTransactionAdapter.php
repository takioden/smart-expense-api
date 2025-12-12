<?php

namespace App\Adapters;

use App\Models\RecurringTransaction;

class RecurringTransactionAdapter
{
    public function transform(RecurringTransaction $rt): array
    {
        return [
            'user_id'     => $rt->user_id,
            'category_id' => $rt->category_id,
            'amount'      => $rt->amount,
            'type'        => $rt->type,
            'description' => $rt->description ?: 'Recurring transaction',
            'date'        => now(), 
        ];
    }
}
