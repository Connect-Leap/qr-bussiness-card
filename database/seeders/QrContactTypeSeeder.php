<?php

namespace Database\Seeders;

use App\Models\QrContactType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QrContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QrContactType::insert(
            [
                [
                    'name' => 'Linkedin',
                    'format_link' => 'https://linkedin.com/in/',
                    'application_year' => now(),
                ],
                [
                    'name' => 'Whatsapp',
                    'format_link' => 'https://api.whatsapp.com/send?phone=',
                    'application_year' => now(),
                ],
                [
                    'name' => 'VCard',
                    'format_link' => null,
                    'application_year' => null,
                ],
            ]
        );
    }
}
