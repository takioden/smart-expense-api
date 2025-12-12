<?php

namespace App\Services;

use App\Models\Transaction;
use App\Adapters\TransactionImportAdapterInterface;
use App\Models\ImportLog;
class TransactionImportService
{
    protected TransactionImportAdapterInterface $adapter;

    public function __construct(TransactionImportAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function import(mixed $input, int $userId, string $source): array
    {
        $data = $this->adapter->parse($input);

        $created = [];

        foreach ($data as $item) {
            $created[] = Transaction::create($item);
        }
        ImportLog::create([
            'user_id' => $userId,
            'source' => $source,
            'total_imported' => count($created),
        ]);

        return $created;
    }
}
