<?php
namespace App\Reports\Strategies;

use App\Models\Transaction;
use App\Config\AppConfig;
use Illuminate\Support\Facades\DB;

class SimpleReportStrategy implements ReportStrategyInterface
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

        $start = "{$year}-{$month}-01 00:00:00";
        $end = date("Y-m-t 23:59:59", strtotime($start)); // end of month

        $totals = Transaction::select(
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
            )
            ->where('user_id', $userId)
            ->whereBetween('date', [$start, $end])
            ->first();

        $totalIncome = (float) ($totals->total_income ?? 0);
        $totalExpense = (float) ($totals->total_expense ?? 0);
        $net = $totalIncome - $totalExpense;
        $currency = $this->config->get('report_currency');

        return [
            'strategy' => 'simple',
            'year' => $year,
            'month' => $month,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net' => $net,
            'currency' => $currency
        ];
    }
}
