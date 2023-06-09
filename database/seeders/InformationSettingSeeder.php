<?php

namespace Database\Seeders;

use App\Models\InformationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InformationSetting::create([
            'application_name' => 'Connect Leap Bussiness Card',
            'application_version' => 'Demo v1.0.0',
            'application_description' => 'Our Motto is Safely Connect and Our Vision is Secure, Fast and Targetted',
        ]);
    }
}
