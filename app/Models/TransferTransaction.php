<?php

namespace App\Models;

use App\Factories\TransactionInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\Category;


class TransferTransaction extends Model implements TransactionInterface
{

    protected $table = 'transactions'; 

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'date',
        'description'
    ];
    
    protected $casts = [
        'amount' => 'float:2',
        'date' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($transaction) {
            $transaction->type = 'transfer';
        });
        
    }
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getAmount(): float
    {
        return (float) $this->amount; 
    }

    public function getType(): string
    {
        return 'transfer';
    }
    
    
}