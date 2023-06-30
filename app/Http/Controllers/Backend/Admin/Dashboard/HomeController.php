<?php

namespace App\Http\Controllers\Backend\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\QR;
use App\Models\QrVisitor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $qr_visitor_device_counter = $this->QrVisitorDeviceCounter();
        $qr_visitor_browser_counter = $this->QrVisitorBrowserCounter();

        return view('pages.dashboard', [
            'qr_visitor_device_counter' => $qr_visitor_device_counter,
            'qr_visitor_browser_counter' => $qr_visitor_browser_counter,
        ]);
    }

    private function QrVisitorDeviceCounter()
    {
        $return_value = array();

        $qr_visitor = new QR;

        if ($this->user()->hasRole('supervisor')) {
            $collection = collect();

            $filter_get_qrvisitor_based_on_user_office_id = $qr_visitor->where('created_for_user_office', $this->user()->office->id)->get()
                ->filter(function ($value) {
                    return $value->qrVisitors->count() > 0;
                })->pluck('qrVisitors');

            foreach ($filter_get_qrvisitor_based_on_user_office_id as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $count_mobile_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == MOBILE;
            })->count();

            $count_tablet_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == TABLET;
            })->count();

            $count_desktop_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == DESKTOP;
            })->count();

            $count_other_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == "OTHER";
            })->count();

        } else { //admin
            $collection = collect();

            $filter_get_all_qrvisitor_that_have_an_items = $qr_visitor->latest()->get()->filter(function ($value) {
                return $value->qrVisitors->count() > 0;
            })->pluck('qrVisitors');

            foreach ($filter_get_all_qrvisitor_that_have_an_items as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $count_mobile_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == MOBILE;
            })->count();

            $count_tablet_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == TABLET;
            })->count();

            $count_desktop_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == DESKTOP;
            })->count();

            $count_other_device = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == "OTHER";
            })->count();
        }

        $return_value['mobile_total'] = $count_mobile_device;
        $return_value['tablet_total'] = $count_tablet_device;
        $return_value['desktop_total'] = $count_desktop_device;
        $return_value['other_total'] = $count_other_device;

        return $return_value;
    }

    private function QrVisitorBrowserCounter()
    {
        $return_value = array();

        $qr_visitor = new QR;

        if ($this->user()->hasRole('supervisor')) {
            $collection = collect();

            $filter_get_qrvisitor_based_on_user_office_id = $qr_visitor->where('created_for_user_office', $this->user()->office->id)->get()
                ->filter(function ($value) {
                    return $value->qrVisitors->count() > 0;
                })->pluck('qrVisitors');

            foreach ($filter_get_qrvisitor_based_on_user_office_id as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $count_chrome_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == CHROME;
            })->count();

            $count_safari_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == SAFARI;
            })->count();

            $count_firefox_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == FIREFOX;
            })->count();

            $count_other_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == "OTHER";
            })->count();

        } else { //admin
            $collection = collect();

            $filter_get_all_qrvisitor_that_have_an_items = $qr_visitor->latest()->get()->filter(function ($value) {
                return $value->qrVisitors->count() > 0;
            })->pluck('qrVisitors');

            foreach ($filter_get_all_qrvisitor_that_have_an_items as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $count_chrome_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == CHROME;
            })->count();

            $count_safari_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == SAFARI;
            })->count();

            $count_firefox_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == FIREFOX;
            })->count();

            $count_other_browser = $collection->filter(function ($value) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == "OTHER";
            })->count();
        }

        $return_value['chrome_total'] = $count_chrome_browser;
        $return_value['safari_total'] = $count_safari_browser;
        $return_value['firefox_total'] = $count_firefox_browser;
        $return_value['other_total'] = $count_other_browser;

        return $return_value;
    }


}
