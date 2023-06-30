<?php

namespace App\Http\Controllers\Backend\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\QR;
use App\Models\QrVisitor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShowScannerController extends Controller
{
    public function show(Request $request)
    {
        $qr_visitors = new QR;

        if (!is_null($request->get('device'))) {
            $qr_visitors = $this->showDeviceScanner($qr_visitors, $request);
        } else {
            $qr_visitors = $this->showBrowserScanner($qr_visitors, $request);
        }

        return view('pages.show-scanner-device', [
            'qr_visitors' => $qr_visitors,
        ]);
    }

    private function showDeviceScanner($qr_visitors, $request)
    {
        if ($this->user()->hasRole('supervisor')) {
            $collection = collect();

            $filter_get_qrvisitor_based_on_user_office_id = $qr_visitors->where('created_for_user_office', $this->user()->office->id)->get()
                ->filter(function ($value) {
                    return $value->qrVisitors->count() > 0;
                })->pluck('qrVisitors');

            foreach ($filter_get_qrvisitor_based_on_user_office_id as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $qr_visitors = $collection->filter(function ($value) use ($request) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == Str::upper($request->device);
            });

        } else { //admin

            $collection = collect();

            $filter_get_all_qrvisitor_that_have_an_items = $qr_visitors->latest()->get()->filter(function ($value) {
                return $value->qrVisitors->count() > 0;
            })->pluck('qrVisitors');

            foreach ($filter_get_all_qrvisitor_that_have_an_items as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $qr_visitors = $collection->filter(function ($value) use ($request) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->device_type == Str::upper($request->device);
            });

        }

        return $qr_visitors;
    }

    private function showBrowserScanner($qr_visitors, $request)
    {
        if ($this->user()->hasRole('supervisor')) {
            $collection = collect();

            $filter_get_qrvisitor_based_on_user_office_id = $qr_visitors->where('created_for_user_office', $this->user()->office->id)->get()
                ->filter(function ($value) {
                    return $value->qrVisitors->count() > 0;
                })->pluck('qrVisitors');

            foreach ($filter_get_qrvisitor_based_on_user_office_id as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $qr_visitors = $collection->filter(function ($value) use ($request) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == ucfirst($request->browser);
            });

        } else { //admin

            $collection = collect();

            $filter_get_all_qrvisitor_that_have_an_items = $qr_visitors->latest()->get()->filter(function ($value) {
                return $value->qrVisitors->count() > 0;
            })->pluck('qrVisitors');

            foreach ($filter_get_all_qrvisitor_that_have_an_items as $raw_data) {
                foreach ($raw_data  as $data) { $collection->push($data); }
            }

            $qr_visitors = $collection->filter(function ($value) use ($request) {
                $decode_json = json_decode($value->detail_visitor_json);

                return $decode_json->visitor_internet_data->browser_name == ucfirst($request->browser);
            });

        }

        return $qr_visitors;
    }
}
