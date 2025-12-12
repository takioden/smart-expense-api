<?php
namespace App\Reports\Strategies;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Config\AppConfig;
class CashFlowReportStrategy implements ReportStrategyInterface
{
    protected AppConfig $config;
    public function __construct()
    {
        $this->config = AppConfig::getInstance();
    }
    public function calculate(int $userId, array $params): array
    {
        $year = $params['year'];
        $month = $params['month'];

        $start = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $end = $start->copy()->endOfMonth()->endOfDay();

        $records = Transaction::select(
                DB::raw("date_trunc('week', date) as week_start"),
                DB::raw("SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as expense")
            )
            ->where('user_id', $userId)
            ->whereBetween('date', [$start, $end])
            ->groupBy('week_start')
            ->orderBy('week_start')
            ->get();

        $weeks = $records->map(function ($row) {
            return [
                'week_start' => $row->week_start,
                'income' => (float) $row->income,
                'expense' => (float) $row->expense,
                'net' => (float) ($row->income - $row->expense),
            ];
        })->values()->all();

        $totalIncome = array_sum(array_column($weeks, 'income'));
        $totalExpense = array_sum(array_column($weeks, 'expense'));
        $currency = $this->config->get('report_currency');
        return [
            'strategy' => 'cashflow',
            'year' => $year,
            'month' => $month,
            'weeks' => $weeks,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net' => $totalIncome - $totalExpense,
            'currency' => $currency
        ];
    }
}
