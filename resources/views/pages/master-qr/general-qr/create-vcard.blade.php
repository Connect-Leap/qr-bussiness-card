@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create your General QR with VCard'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Create your General QR with VCard</h6>
                    <a href="{{ route('general-qr.index') }}" class="btn btn-info btn-sm">Back</a>
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
                        <form action="{{ route('general-qr.create-vcard') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="qr_name" class="form-control {{ session()->has('fail') ? 'is-invalid' : '' }}" placeholder="QR Name" aria-label="QR Name" value="{{ old('qr_name') }}" required>
                            </div>
                            <div class="mb-3">
                                <select name="qr_contact_type_id" class="form-select" required>
                                    <option value="" selected hidden>Select Contact Type</option>
                                    <option value="{{ $contact_type->id }}" selected>{{ $contact_type->name }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="office_id" class="form-select" required>
                                    <option value="" selected hidden>Select Offices</option>
                                    @foreach($offices as $office)
                                    <option value="{{ $office->id }}" @selected(old('office_id') == $office->id)>{{ $office->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="usage_limit" class="form-select" required>
                                    <option value="" selected hidden>Select Scan Usage Limit</option>
                                    @forelse($settings as $setting)
                                    <option value="{{ $setting->default_scan_limit }}" @selected(old('usage_limit') == $setting->id)>{{ $setting->default_scan_limit }}</option>
                                    @empty
                                    <option value="3">3</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ route('general-qr.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
