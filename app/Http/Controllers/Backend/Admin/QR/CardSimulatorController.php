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
        // Gate
        if (!$this->user()->hasPermissionTo('show-find-card-simulator')) {
            $this->throwUnauthorizedException(['show-find-card-simulator']);
        }
        // End Gate

        $users = User::where('role', 'employee')->latest()->get()->filter(function ($value) {
            return $value->Qr !== null;
        })->values();

        if ($this->user()->hasRole('supervisor')) {
            $users = $users->filter(function ($value) {
                return $value->office->id === $this->user()->office_id;
            });
        }

        return view('pages.master-qr.card-simulator.find-user', [
            'users' => $users,
        ]);
    }

    public function showCard(QrCodeResource $qrCodeResource)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-card-simulator-page')) {
            $this->throwUnauthorizedException(['show-card-simulator-page']);
        }

        $get_office_id_from_route_parameter_user_id = User::where('id', request()->get('user_id'))->get()->pluck('office.id')->first();

        if (is_null($get_office_id_from_route_parameter_user_id)) {
            $this->throwException(404, 'User Not Found');
        }

        if (!$this->user()->hasRole('admin') && $this->user()->office_id != $get_office_id_from_route_parameter_user_id) {
            $this->throwException(401);
        }
        // End Gate

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
