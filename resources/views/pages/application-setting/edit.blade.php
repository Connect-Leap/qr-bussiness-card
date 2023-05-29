@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Application Configuration'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Edit Application Configuration</h6>
                    <a href="{{ route('application-setting.index') }}" class="btn btn-info btn-sm">Back</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        @if (Session::has('errors'))
                        <div class="my-2">
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li class="text-light fw-bold">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        <form action="{{ route('application-setting.update', $setting->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <input type="number" name="default_scan_limit" class="form-control" placeholder="Default Scan Limit" aria-label="Default Scan Limit" value="{{ old('default_scan_limit', $setting->default_scan_limit) }}">
                            </div>
                            <div class="mb-3">
                                <input type="number" name="default_rate_limit" class="form-control" placeholder="Default Rate Limit (Optional)" aria-label="Default Rate Limit" value="{{ old('default_rate_limit', ($setting->default_rate_limit ?? '')) }}">
                            </div>
                            <div class="mb-3">
                                <input type="number" name="default_rate_time_limit" class="form-control" placeholder="Default Rate Time Limit (Optional)" aria-label="Default Rate Time Limit" value="{{ old('default_rate_time_limit', ($setting->default_rate_time_limit ?? '')) }}">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ route('application-setting.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
