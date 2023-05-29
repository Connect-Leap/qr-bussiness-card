<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardSimulatorController extends Controller
{
    public function findUserView(Request $request)
    {
        return view('pages.master-qr.card-simulator.find-user');
    }

    public function showCard()
    {
        return view('pages.master-qr.card-simulator.view-card');
    }
}
