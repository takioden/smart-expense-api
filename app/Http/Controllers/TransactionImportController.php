<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionImportService;
use App\Adapters\CsvTransactionAdapter;
use App\Adapters\JsonTransactionAdapter;
use App\Adapters\ApiTransactionAdapter;

class TransactionImportController extends Controller
{
    public function import(Request $request)
    {
        $source = $request->query('source');

        switch ($source) {
            case 'csv':
                $adapter = new CsvTransactionAdapter();
                $input = $request->file('file');
                break;

            case 'json':
                $adapter = new JsonTransactionAdapter();
                $input = $request->file('file');
                break;

            case 'api':
                $adapter = new ApiTransactionAdapter();
                $input = $request->query('url');
                break;

            default:
                return response()->json(['error' => 'Unknown source'], 400);
        }

        $service = new TransactionImportService($adapter);
        
        $data = $service->import($input, auth()->id(), $source);


        return response()->json($data);
    }
}
