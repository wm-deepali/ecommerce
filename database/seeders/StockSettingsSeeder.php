<?php

namespace Database\Seeders;

use App\Models\StockSetting;
use Illuminate\Database\Seeder;

class StockSettingsSeeder extends Seeder
{
    public function run(): void
    {
        StockSetting::query()->firstOrCreate([], [
            'critical_threshold' => 0,
            'low_stock_threshold' => 20,
            'watch_list_threshold' => 30,
            'notify_email' => true,
            'notify_dashboard' => true,
            'auto_disable_out_of_stock' => true,
        ]);
    }
}