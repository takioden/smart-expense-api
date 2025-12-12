<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }


    public function index(Request $request)
    {
        $userId = $request->user()->id;

        return response()->json([
            'status' => 'success',
            'data' => $this->transactionService->getAllByUser($userId)
        ]);
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|in:income,expense,transfer',
            'amount'      => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'nullable|date',
            'description' => 'nullable|string'
        ]);

        if (empty($validated['date'])) {
        $validated['date'] = Carbon::now();
        }
        
        $validated['user_id'] = $request->user()->id;

        $this->transactionService->store($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction created successfully'
        ], 201);
    }

 
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'amount'      => 'sometimes|numeric',
            'type'        => 'sometimes|in:income,expense,transfer',
            'category_id' => 'sometimes|exists:categories,id',
            'date'        => 'sometimes|date',
            'description' => 'nullable|string'
        ]);


        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }


        if ($request->user()->id !== $transaction->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

   
        $updated = $this->transactionService->update($transaction, $validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction updated successfully',
            'data' => $updated
        ]);
    }


 
    public function destroy(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        if ($request->user()->id !== $transaction->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $this->transactionService->delete($transaction);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction deleted successfully'
        ]);
    }
}
