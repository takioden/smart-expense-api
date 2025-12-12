<?php

namespace App\Factories;

interface TransactionInterface
{
    public function getAmount(): float;
    public function getType(): string;
    public function save();
}
