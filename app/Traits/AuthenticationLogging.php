<?php

namespace App\Traits;

use App\Models\User;

trait AuthenticationLogging
{
    public function updateAuthLogging(mixed $user_id, bool $is_login = true)
    {
        $user = User::where('id', $user_id)->first();

        if ($is_login) return $user->update(['is_login' => true, 'login_at' => now()]);

        return $user->update(['is_login' => false, 'logout_at' => now()]);
    }
}
