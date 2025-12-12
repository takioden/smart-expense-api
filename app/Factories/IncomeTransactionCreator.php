<?php

namespace App\Factories;

use App\Models\IncomeTransaction;

class IncomeTransactionCreator extends TransactionCreator
{
    public function create(array $data): TransactionInterface
    {
        return new IncomeTransaction($data);
    }
}
