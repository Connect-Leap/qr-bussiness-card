<?php

namespace App\Http\Controllers\Backend\Admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        $authenticated_user = auth()->user();
        $total_online_hour = diffDatetimeCounter(auth()->user()->login_at);
        $total_usage_hour = diffDatetimeCounter(auth()->user()->created_at);

        return view('pages.profile.user-profile', [
            'total_online_hour' => $total_online_hour,
            'total_usage_hour' => $total_usage_hour,
            'user' => $authenticated_user,
        ]);
    }
}
