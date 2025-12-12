<?php

namespace App\Services;

use App\Factories\TransactionCreator;
use App\Factories\IncomeTransactionCreator;
use App\Factories\ExpenseTransactionCreator;
use App\Factories\TransferTransactionCreator;
use App\Models\Transaction;
use App\Config\AppConfig;

class TransactionService
{
    private AppConfig $config;

    public function __construct()
    {
        $this->config = AppConfig::getInstance();
    }


    public function getAllByUser(int $userId)
    {
        date_default_timezone_set(
            $this->config->get('default_timezone')
        );

        return Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();
    }



    private function resolveCreator(string $type): TransactionCreator
    {
        return match ($type) {
            'income' => new IncomeTransactionCreator(),
            'expense' => new ExpenseTransactionCreator(),
            'transfer' => new TransferTransactionCreator(),
            default => throw new \InvalidArgumentException("Unknown type {$type}")
        };
    }



    public function store(array $data)
    {
        date_default_timezone_set(
            $this->config->get('default_timezone')
        );

        $creator = $this->resolveCreator($data['type']);

        $transaction = $creator->create($data);
        $transaction->save();

        return $transaction;
    }



    public function update(Transaction $transaction, array $data)
    {
        $transaction->update($data);

        $transaction->refresh();
        
        return $transaction; 
    }

    public function delete(Transaction $transaction)
    {
        return $transaction->delete();
    }
}
