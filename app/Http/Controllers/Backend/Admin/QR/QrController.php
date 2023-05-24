<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Http\Controllers\Controller;
use App\Models\QR;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function index()
    {
        $qrs = QR::latest()->get();

        return view('pages.master-qr.index', [
            'qrs' => $qrs
        ]);
    }

    public function create()
    {
        return view('pages.master-qr.create');
    }

    public function edit($id)
    {
        $qr = QR::where('id', $id)->first();

        return view('pages.master-qr.edit', [
            'qr' => $qr
        ]);
    }
}
