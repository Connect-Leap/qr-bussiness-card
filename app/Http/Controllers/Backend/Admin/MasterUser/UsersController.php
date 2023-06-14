<?php

namespace App\Http\Controllers\Backend\Admin\MasterUser;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function seeAllUsers()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-all-users')) {
            $this->throwUnauthorizedException(['show-all-users']);
        }
        // End Gate

        $roles = ['employee', 'supervisor'];

        $users = User::whereIn('role', $roles)->latest()->get();
        $user_total = $users->count();
        $user_supervisor_total = User::where('role', 'supervisor')->count();
        $user_employee_total = User::where('role', 'employee')->count();

        return view('pages.master-user.detail-users.index', [
            'users' => $users,
            'user_total' => $user_total,
            'user_supervisor_total' => $user_supervisor_total,
            'user_employee_total' => $user_employee_total
        ]);
    }
}
