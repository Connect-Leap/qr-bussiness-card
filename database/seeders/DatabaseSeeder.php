<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserAdminSeeder::class,
            QrContactTypeSeeder::class,
            OfficeSeeder::class,
            ApplicationSettingSeeder::class,
            UserEmployeeSeeder::class,
        ]);
    }
}
