<?php
namespace App\Adapters;

use Illuminate\Support\Facades\Http;

class ApiTransactionAdapter implements TransactionImportAdapterInterface
{
    public function parse($url): array
    {
        $response = Http::get($url);

        if (!$response->successful()) {
            return [];
        }

        return $response->json();
    }
}
