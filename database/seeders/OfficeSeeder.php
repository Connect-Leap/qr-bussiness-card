<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = array();

        for ($i = 0; $i <= 300; $i++) {
            $offices[] = [
                'name' => fake()->company(),
                'address' => fake()->address(),
                'email' => fake()->companyEmail(),
                'contact' => '(012)-123123'
            ];
        }

        foreach (array_chunk($offices, 30) as $office) {
            Office::insert($office);
        }
    }
}
