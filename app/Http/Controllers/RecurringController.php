<?php
namespace App\Http\Controllers;

use App\Services\RecurringService;
use Illuminate\Http\Request;

class RecurringController extends Controller
{
    protected RecurringService $service;

    public function __construct(RecurringService $service)
    {
        $this->service = $service;
    }

    public function testGenerate()
    {
        $result = $this->service->generateDueRecurring();

        return response()->json([
            'generated' => count($result),
            'data' => $result
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'category_id' => 'required|integer',
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'recurrence_period' => 'required|string|in:daily,weekly,monthly',
        ]);

        $create = $this->service->createRecurring($validated);

        return response()->json([
            'success' => true,
            'data' => $create
        ]);
    }

}
