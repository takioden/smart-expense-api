<?php

namespace App\Config;

class AppConfig
{
    private static ?AppConfig $instance = null;

    private array $settings = [
        'default_timezone' => 'Asia/Jakarta',
        'report_currency' => 'IDR',
        'enable_recurring_job' => true,
        'max_import_rows' => 5000
    ];

    
    private function __construct() {}

    
    public static function getInstance(): AppConfig
    {
        if (!self::$instance) {
            self::$instance = new AppConfig();
        }

        return self::$instance;
    }

    public function get(string $key)
    {
        return $this->settings[$key] ?? null;
    }

    
    public function set(string $key, mixed $value): void
    {
        $this->settings[$key] = $value;
    }
}
