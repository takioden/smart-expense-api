<?php
namespace App\Adapters;

class CsvTransactionAdapter implements TransactionImportAdapterInterface
{
    public function parse($file): array
    {
        $transactions = [];
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle); // baca header

        while (($row = fgetcsv($handle)) !== false) {
            $transactions[] = array_combine($header, $row);
        }

        fclose($handle);

        return $transactions;
    }
}
