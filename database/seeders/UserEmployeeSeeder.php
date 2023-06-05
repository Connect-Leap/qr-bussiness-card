<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $office = Office::count();

        for ($i = 0; $i <= 100; $i++) {
            app('CreateUser')->execute([
                'office_id' => fake()->numberBetween(1, $office),
                'role' => 'employee',
                'name' => fake()->name(),
                'employee_code' => 'EMP-00'.($i + 1),
                'gender' => fake()->randomElement(['male', 'female']),
                'email' => fake()->email(),
                'password' => '123123',
                'phone_number' => '081290240392',
                'department_name' => 'Department A',
                'user_position' => fake()->jobTitle(),
                'user_position_period' => now()->format('Y'),
                'country_name' => 'Indonesia',
                'country_code' => 'INA',
                'country_phone_code' => '+62',
            ]);
        }
    }
}
