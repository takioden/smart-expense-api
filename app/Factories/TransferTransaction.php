<?php

namespace App\Models;

use App\Factories\TransactionInterface;
use Illuminate\Database\Eloquent\Model;

class TransferTransaction extends Model implements TransactionInterface
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'date',
        'description'
    ];

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getType(): string
    {
        return 'transfer';
    }
}
