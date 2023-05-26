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
        Office::create([
            'name' => 'Connect Leap',
            'address' => 'Office Address',
            'email' => 'cs@connectleap.com',
            'contact' => '(012)-123123'
        ]);
    }
}
