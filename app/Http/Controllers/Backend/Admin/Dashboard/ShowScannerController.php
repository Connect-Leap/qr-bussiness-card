<?php

namespace App\Http\Controllers\Backend\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\QrVisitor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShowScannerController extends Controller
{
    public function show(Request $request)
    {
        $qr_visitors = QrVisitor::latest()->get()->filter(function ($value) use($request) {
            $decode_json = json_decode($value->detail_visitor_json);

            return $decode_json->visitor_internet_data->device_type == Str::upper($request->device);
        });

        return view('pages.show-scanner-device', [
            'qr_visitors' => $qr_visitors,
        ]);
    }
}
