<?php

namespace App\Http\Controllers\Backend\Admin\MasterOffice;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManagementOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offices = Office::latest()->get();

        return view('pages.master-office.management-office.index', [
            'offices' => $offices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.master-office.management-office.create');
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:offices,email'],
            'contact' => ['required', 'min:9', 'max:13'],
        ]);

        $process = app('CreateOffice')->execute([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'contact' => $request->contact
        ]);

        return redirect()->route('management-office.index')->with('success', $process['message']);
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
        $process = app('FindOfficeById')->execute([
            'office_id' => $id,
        ]);

        if (!$process['success']) return redirect()->route('management-office.index')->with('fail', $process['message']);

        return view('pages.master-office.management-office.edit', [
            'office' => $process['data']
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique('offices')->ignore($id)],
            'contact' => ['required', 'min:9', 'max:13'],
        ]);

        $process = app('UpdateOffice')->execute([
            'office_id' => $id,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'contact' => $request->contact,
        ]);

        if (!$process['success']) return redirect()->route('management-office.index')->with('fail', $process['message']);

        return redirect()->route('management-office.index')->with('success', $process['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $process = app('DeleteOffice')->execute([
            'office_id' => $id
        ]);

        if (!$process['success']) return response()->json(['error' => $process['message']], $process['response_code']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }
}
