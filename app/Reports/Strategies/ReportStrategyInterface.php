<?php
namespace App\Reports\Strategies;

interface ReportStrategyInterface
{
    /**
     *
     * @param int $userId
     * @param array $params  // e.g. ['year'=>2025,'month'=>11]
     * @return array
     */
    public function calculate(int $userId, array $params): array;
}
