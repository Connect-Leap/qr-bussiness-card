<?php

namespace Database\Seeders;

use App\Models\ApplicationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApplicationSetting::create([
            'default_scan_limit' => 5,
            'default_rate_limit' => 3,
            'default_rate_time_limit' => 60
        ]);
    }
}
