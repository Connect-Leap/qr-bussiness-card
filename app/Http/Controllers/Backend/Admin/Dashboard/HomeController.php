<?php

namespace App\Http\Controllers\Backend\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\QrVisitor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $qr_visitor_device_counter = $this->QrVisitorDeviceCounter();

        return view('pages.dashboard', [
            'qr_visitor_device_counter' => $qr_visitor_device_counter,
        ]);
    }

    private function QrVisitorDeviceCounter()
    {
        $return_value = array();

        $qr_visitor = QrVisitor::latest()->get();

        $count_mobile_device = $qr_visitor->filter(function ($value) {
            $decode_json = json_decode($value->detail_visitor_json);

            return $decode_json->visitor_internet_data->device_type == MOBILE;
        })->count();

        $count_tablet_device = $qr_visitor->filter(function ($value) {
            $decode_json = json_decode($value->detail_visitor_json);

            return $decode_json->visitor_internet_data->device_type == TABLET;
        })->count();

        $count_desktop_device = $qr_visitor->filter(function ($value) {
            $decode_json = json_decode($value->detail_visitor_json);

            return $decode_json->visitor_internet_data->device_type == DESKTOP;
        })->count();

        $count_other_device = $qr_visitor->filter(function ($value) {
            $decode_json = json_decode($value->detail_visitor_json);

            return $decode_json->visitor_internet_data->device_type == "OTHER";
        })->count();

        $return_value['mobile_total'] = $count_mobile_device;
        $return_value['tablet_total'] = $count_tablet_device;
        $return_value['desktop_total'] = $count_desktop_device;
        $return_value['other_total'] = $count_other_device;

        return $return_value;
    }


}
