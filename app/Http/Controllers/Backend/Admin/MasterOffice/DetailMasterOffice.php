<?php

namespace App\Http\Controllers\Backend\Admin\MasterOffice;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailMasterOffice extends Controller
{
    public function index()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-detail-office')) {
            $this->throwUnauthorizedException(['show-detail-office']);
        }
        // End Gate

        $offices = Office::latest()->get();

        if ($this->user()->hasRole('supervisor')) {
            $offices = $offices->filter(function ($value) {
                return $value->id === $this->user()->office_id;
            });
        }

        return view('pages.master-office.office-list.index', [
            'offices' => $offices
        ]);
    }

    public function showEmployee($office_id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-detail-office')) {
            $this->throwUnauthorizedException(['show-detail-office']);
        }

        if ($this->user()->office_id != $office_id) {
            $this->throwException(401);
        }
        // End Gate

        $process = app('ShowRelatedUser')->execute([
            'office_id' => $office_id
        ]);

        return view('pages.master-office.office-list.show-employee', [
            'users' => $process['data']['users'],
            'user_total' => $process['data']['user_total'],
            'user_supervisor_total' => $process['data']['user_supervisor_total'],
            'user_employee_total' => $process['data']['user_employee_total'],
            'office' => $process['data']['office'],
        ]);
    }
}
