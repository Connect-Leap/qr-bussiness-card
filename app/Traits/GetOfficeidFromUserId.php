<?php


namespace App\Traits;

use App\Models\User;

trait GetOfficeidFromUserId
{
    public function getOfficeIdFromUserId(int $request_user_id)
    {
        $user = User::where('id', $request_user_id)->first();

        return $user->office->id;
    }
}
