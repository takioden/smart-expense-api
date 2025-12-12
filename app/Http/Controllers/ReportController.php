<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected ReportService $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function monthly(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|integer|min:2000',
            'month' => 'required|integer|between:1,12',
            'strategy' => 'sometimes|string|in:simple,cashflow,category'
        ]);

        $userId = $request->user()->id;
        $strategy = $data['strategy'] ?? 'simple';

        $report = $this->service->monthlyReport($userId, $data['year'], $data['month'], $strategy);

        return response()->json($report);
    }
}
