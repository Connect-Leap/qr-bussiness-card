@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'QR Configuration'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>QR Configuration</h6>
                    <a href="{{ route('master-qr.create') }}" class="btn btn-info btn-sm">Create your QR</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Contact Type</th>
                                    <th>QR Owner (User)</th>
                                    <th>Show QR</th>
                                    <th>Usage Limit Remain</th>
                                    <th>QR Status</th>
                                    <th>Action</th>
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
@endsection
