<?php

namespace App\Factories;

abstract class TransactionCreator
{
    abstract public function create(array $data): TransactionInterface;

    public function process(array $data): TransactionInterface
    {
        $transaction = $this->create($data); 

        $transaction->save();

        return $transaction;
    }
}
