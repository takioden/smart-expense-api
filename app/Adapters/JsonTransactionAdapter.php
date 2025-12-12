<?php
namespace App\Adapters;

class JsonTransactionAdapter implements TransactionImportAdapterInterface
{
    public function parse($file): array
    {
        $json = file_get_contents($file->getRealPath());
        return json_decode($json, true);
    }
}
