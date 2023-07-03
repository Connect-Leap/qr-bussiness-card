<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAdmin;
use App\Models\UserNationality;
use App\Models\UserPosition;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $created_user = User::create([
            'country_id' => 247,
            'email' => 'user@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'gender' => 'male',
            'remember_token' => Str::random(10)
        ]);

        UserAdmin::create([
            'user_id' => $created_user->id,
            'name' => 'Connect Leap Admin',
        ]);

        UserPosition::create([
            'user_id' => $created_user->id,
            'name' => 'Connect Leap Admin',
            'period' => '2023'
        ]);

        $created_user->assignRole('admin');
        $created_user->givePermissionTo(array_diff(config('permission.list-permission'), ['update-profile', 'edit-user-qr', 'update-user-qr']));
    }
}
