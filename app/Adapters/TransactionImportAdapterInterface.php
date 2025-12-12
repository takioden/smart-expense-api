<?php
namespace App\Adapters;

interface TransactionImportAdapterInterface
{
    public function parse(mixed $input): array;
}
