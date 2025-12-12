<?php

namespace App\Factories;

use App\Models\ExpenseTransaction;

class ExpenseTransactionCreator extends TransactionCreator
{
    public function create(array $data): TransactionInterface
    {
        return new ExpenseTransaction($data);
    }
}
