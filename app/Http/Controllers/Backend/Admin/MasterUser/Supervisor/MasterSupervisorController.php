<?php

namespace App\Http\Controllers\Backend\Admin\MasterUser\Supervisor;

use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class MasterSupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'supervisor')->latest()->get();

        return view('pages.master-user.supervisor.index', [
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
        $offices = Office::latest()->get();

        return view('pages.master-user.supervisor.create', [
            'offices' => $offices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'office_id' => ['required'],
            'name' => ['required', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'department_name' => ['required', 'max:255'],
            'user_position' => ['required', 'max:255'],
            'user_position_period' => ['required'],
            'country_name' => ['required', 'max:255'],
            'country_code' => ['required', 'min:2'],
            'country_phone_code' => ['required', 'min:2'],
        ]);

        $process = app('CreateUser')->execute([
            'office_id' => $request->office_id,
            'role' => 'supervisor',
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => $request->password,
            'department_name' => $request->department_name,
            'user_position' => $request->user_position,
            'user_position_period' => $request->user_position_period,
            'country_name' => $request->country_name,
            'country_code' => $request->country_code,
            'country_phone_code' => $request->country_phone_code,
        ]);

        if (!$process['success']) return response()->json($process);

        return redirect()->route('management-supervisor.index')->with('success', $process['message']);
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
        $user = User::where('id', $id)->first();
        $offices = Office::latest()->get();

        return view('pages.master-user.supervisor.edit', [
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'office_id' => ['required'],
            'name' => ['required', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'department_name' => ['required', 'max:255'],
            'user_position' => ['required', 'max:255'],
            'user_position_period' => ['required'],
            'country_name' => ['required', 'max:255'],
            'country_code' => ['required', 'min:2'],
            'country_phone_code' => ['required', 'min:2'],
        ]);

        $process = app('UpdateUser')->execute([
            'office_id' => $request->office_id,
            'user_id' => $id,
            'role' => 'supervisor',
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'department_name' => $request->department_name,
            'user_position' => $request->user_position,
            'user_position_period' => $request->user_position_period,
            'country_name' => $request->country_name,
            'country_code' => $request->country_code,
            'country_phone_code' => $request->country_phone_code,
        ]);

        if (!$process['success']) return response()->json($process);

        return redirect()->route('management-supervisor.index')->with('success', $process['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $process = app('DeleteUser')->execute([
            'user_id' => $id
        ]);

        if (!$process['success']) return response()->json(['error' => $process['message']], $process['response_code']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }
}
