@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'General QR Configuration'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0 mb-3">
                    <h6>General QR Configuration</h6>
                    @can('reset-all-user-qr', 'create-user-qr', 'create-user-qr-vcard')
                    <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-warning" href="{{ route('master-qr.reset-all-user-qr-code') }}">Reset All Usage Limit</a>
                        <a href="{{ route('general-qr.create') }}" class="btn btn-info btn-sm">Create your QR</a>
                        <a href="{{ route('general-qr.create-vcard') }}" class="btn btn-info btn-sm">Create your QR with VCard</a>
                    </div>
                    @endcan
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="table-responsive p-0">
                            <table class="table datatable-jquery align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Contact Type</th>
                                        <th class="text-center">QR Owner (Office)</th>
                                        <th class="text-center">Show QR</th>
                                        <th class="text-center">Usage Limit Remain</th>
                                        <th class="text-center">QR Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">Empty Data</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
