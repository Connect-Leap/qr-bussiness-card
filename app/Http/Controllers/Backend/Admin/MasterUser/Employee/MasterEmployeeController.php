<?php

namespace App\Http\Controllers\Backend\Admin\MasterUser\Employee;

use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Employee\StoreEmployeeRequest;
use App\Http\Requests\Users\Employee\UpdateEmployeeRequest;

class MasterEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-employee')) {
            $this->throwUnauthorizedException(['show-employee']);
        }
        // End Gate

        $users = User::where('role', 'employee')->latest()->get();

        if ($this->user()->hasRole('supervisor')) {
            $users = $users->filter(function ($value) {
                return $value->office->id == $this->user()->office_id;
            });
        }

        return view('pages.master-user.employee.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('create-employee')) {
            $this->throwUnauthorizedException(['create-employee']);
        }
        // End Gate

        $offices = Office::latest()->get();

        if ($this->user()->hasRole('supervisor')) {
            $offices = $offices->filter(function ($value) {
                return $value->id == $this->user()->office_id;
            });
        }

        return view('pages.master-user.employee.create', [
            'offices' => $offices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('store-employee')) {
            $this->throwUnauthorizedException(['store-employee']);
        }
        // End Gate

        $process = app('CreateUser')->execute([
            'office_id' => $request->office_id,
            'role' => 'employee',
            'name' => $request->name,
            'employee_code' => $request->employee_code,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'department_name' => $request->department_name,
            'user_position' => $request->user_position,
            'user_position_period' => $request->user_position_period,
            'country_name' => $request->country_name,
            'country_code' => $request->country_code,
            'country_phone_code' => $request->country_phone_code,
        ]);

        if (!$process['success']) return response()->json($process);

        return redirect()->route('management-employee.index')->with('success', $process['message']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('edit-employee')) {
            $this->throwUnauthorizedException(['edit-employee']);
        }

        $get_office_id_from_route_parameter_user_id = User::where('id', $id)->get()->pluck('office.id')->first();
        if (!$this->user()->hasRole('admin') && $this->user()->office_id != $get_office_id_from_route_parameter_user_id) {
            $this->throwException(401);
        }
        // End Gate

        $user = User::where('id', $id)->first();

        $offices = Office::latest()->get();
        if ($this->user()->hasRole('supervisor')) {
            $offices = $offices->filter(function ($value) {
                return $value->id == $this->user()->office_id;
            });
        }

        return view('pages.master-user.employee.edit', [
            'user' => $user,
            'offices' => $offices,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('update-employee')) {
            $this->throwUnauthorizedException(['update-employee']);
        }

        $get_office_id_from_route_parameter_user_id = User::where('id', $id)->get()->pluck('office.id')->first();
        if (!$this->user()->hasRole('admin') && $this->user()->office_id != $get_office_id_from_route_parameter_user_id) {
            $this->throwException(401);
        }
        // End Gate

        $process = app('UpdateUser')->execute([
            'office_id' => $request->office_id,
            'user_id' => $id,
            'role' => 'employee',
            'name' => $request->name,
            'employee_code' => $request->employee_code,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'department_name' => $request->department_name,
            'user_position' => $request->user_position,
            'user_position_period' => $request->user_position_period,
            'country_name' => $request->country_name,
            'country_code' => $request->country_code,
            'country_phone_code' => $request->country_phone_code,
        ]);

        if (!$process['success']) return response()->json($process);

        return redirect()->route('management-employee.index')->with('success', $process['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('delete-employee')) {
            $this->throwUnauthorizedException(['delete-employee']);
        }

        $get_office_id_from_route_parameter_user_id = User::where('id', $id)->get()->pluck('office.id')->first();
        if (!$this->user()->hasRole('admin') && $this->user()->office_id != $get_office_id_from_route_parameter_user_id) {
            $this->throwException(401);
        }
        // End Gate

        $process = app('DeleteUser')->execute([
            'user_id' => $id
        ]);

        if (!$process['success']) return response()->json(['error' => $process['message']], $process['response_code']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }
}
