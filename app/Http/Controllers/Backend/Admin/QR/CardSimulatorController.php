<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Http\Controllers\Controller;
use App\Http\Resources\QrCodeResource;
use App\Models\QR;
use App\Models\User;
use Illuminate\Http\Request;

class CardSimulatorController extends Controller
{
    public function findUserView(Request $request)
    {
        $users = User::where('role', 'employee')->latest()->get()->filter(function ($value) {
            return $value->Qr !== null;
        })->values();

        return view('pages.master-qr.card-simulator.find-user', [
            'users' => $users,
        ]);
    }

    public function showCard(QrCodeResource $qrCodeResource)
    {
        $user = User::where('id', request()->get('user_id'))->where('role', 'employee')->first();
        $qr = $qrCodeResource->toArray(QR::where('user_id', $user->id)->get());

        if (is_null($user) || is_null($user->Qr)) {
            abort(404);
        }

        return view('pages.master-qr.card-simulator.view-card', [
            'user' => $user,
            'qr' => $qr[0],
        ]);
    }
}
