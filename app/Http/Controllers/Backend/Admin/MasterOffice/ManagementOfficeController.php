<?php

namespace App\Http\Controllers\Backend\Admin\MasterOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\StoreOfficeRequest;
use App\Http\Requests\Office\UpdateOfficeRequest;
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
        // Gate
        if (!$this->user()->hasPermissionTo('show-office')) {
            $this->throwUnauthorizedException(['show-office']);
        }
        // End Gate

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
        // Gate
        if (!$this->user()->hasPermissionTo('create-office')) {
            $this->throwUnauthorizedException(['create-office']);
        }
        // End Gate

        return view('pages.master-office.management-office.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeRequest $request)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('store-office')) {
            $this->throwUnauthorizedException(['store-office']);
        }
        // End Gate

        $process = app('CreateOffice')->execute([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'contact' => $request->contact,
            'company_link' => $request->company_link ?? null,
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
        // Gate
        if (!$this->user()->hasPermissionTo('edit-office')) {
            $this->throwUnauthorizedException(['edit-office']);
        }
        // End Gate

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
    public function update(UpdateOfficeRequest $request, $id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('update-office')) {
            $this->throwUnauthorizedException(['update-office']);
        }
        // End Gate

        $process = app('UpdateOffice')->execute([
            'office_id' => $id,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'contact' => $request->contact,
            'company_link' => $request->company_link ?? null,
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
        // Gate
        if (!$this->user()->hasPermissionTo('delete-office')) {
            $this->throwUnauthorizedException(['delete-office']);
        }
        // End Gate

        $process = app('DeleteOffice')->execute([
            'office_id' => $id
        ]);

        if (!$process['success']) return response()->json(['error' => $process['message']], $process['response_code']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }
}
