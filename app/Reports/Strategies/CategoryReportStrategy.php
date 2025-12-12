<?php
namespace App\Reports\Strategies;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Config\AppConfig;

class CategoryReportStrategy implements ReportStrategyInterface
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
        $end = date("Y-m-t 23:59:59", strtotime($start));

        $rows = Transaction::select('category_id',
                DB::raw("SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as expense")
            )
            ->where('user_id', $userId)
            ->whereBetween('date', [$start, $end])
            ->groupBy('category_id')
            ->with('category') // eager load category relation
            ->get();

        $breakdown = $rows->map(function ($r) {
            return [
                'category_id' => $r->category_id,
                'category_name' => optional($r->category)->name,
                'income' => (float)$r->income,
                'expense' => (float)$r->expense,
                'net' => (float)($r->income - $r->expense),
            ];
        })->all();

        $totalIncome = array_sum(array_column($breakdown, 'income'));
        $totalExpense = array_sum(array_column($breakdown, 'expense'));
        $currency = $this->config->get('report_currency');
        return [
            'strategy' => 'category',
            'year' => $year,
            'month' => $month,
            'breakdown' => $breakdown,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net' => $totalIncome - $totalExpense,
            'currency' => $currency
        ];
    }
}
