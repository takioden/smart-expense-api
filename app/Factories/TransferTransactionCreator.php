<?php

namespace App\Factories;

use App\Models\TransferTransaction;

class TransferTransactionCreator extends TransactionCreator
{
    public function create(array $data): TransactionInterface
    {
        return new TransferTransaction($data);
    }
}
