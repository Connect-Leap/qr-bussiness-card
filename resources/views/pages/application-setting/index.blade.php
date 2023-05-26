@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Application Setting'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Application Setting</h6>
                    <a href="{{ route('application_setting.create') }}" class="btn btn-info btn-sm">Create your First Configuration</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Default Scan Limit</th>
                                    <th>Default Rate Limit For Scan</th>
                                    <th>Default Rate Time Limit For Scan</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($settings as $setting)
                                <tr>
                                    <td>
                                        <p class="text-center text-sm font-weight-bold mb-0">#</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-sm font-weight-bold mb-0">{{ $setting->default_scan_limit }}</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-sm font-weight-bold mb-0">{{ $setting->default_rate_limit }}</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-sm font-weight-bold mb-0">{{ $setting->default_rate_time_limit }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('application-setting.edit', $setting->id) }}" class="btn btn-xs btn-success">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p class="text-sm font-weight-bold mb-0">Empty Data</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
