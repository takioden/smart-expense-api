<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'type', 
        'recurrence_period', 
        'last_execution_date',
        'next_execution_date',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'last_execution_date' => 'date',
        'next_execution_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
