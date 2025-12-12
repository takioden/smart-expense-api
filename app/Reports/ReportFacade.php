<?php
namespace App\Reports;

use App\Reports\Strategies\ReportStrategyInterface;
use App\Reports\Strategies\SimpleReportStrategy;
use App\Reports\Strategies\CashFlowReportStrategy;
use App\Reports\Strategies\CategoryReportStrategy;

class ReportFacade
{
   
    protected function resolveStrategy(string $key): ReportStrategyInterface
    {
        return match ($key) {
            'simple' => new SimpleReportStrategy(),
            'cashflow' => new CashFlowReportStrategy(),
            'category' => new CategoryReportStrategy(),
            default => new SimpleReportStrategy()
        };
    }

   
    public function generate(string $strategyKey, int $userId, array $params = []): array
    {
        $strategy = $this->resolveStrategy($strategyKey);
        return $strategy->calculate($userId, $params);
    }
}
