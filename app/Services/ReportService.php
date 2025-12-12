<?php
namespace App\Services;
use App\Config\AppConfig;
use App\Reports\ReportFacade;
class ReportService
{
    protected ReportFacade $facade;

    public function __construct()
    {
        $this->facade = new ReportFacade();
    }

    public function monthlyReport(int $userId, int $year, int $month, string $strategy = 'simple'): array
    {
        $params = ['year' => $year, 'month' => $month];
        return $this->facade->generate($strategy, $userId, $params);
    }
}
