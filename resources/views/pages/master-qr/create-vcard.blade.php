@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create your QR with VCard'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Create your QR with VCard</h6>
                    <a href="{{ route('master-qr.index') }}" class="btn btn-info btn-sm">Back</a>
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
                        <form action="{{ route('master-qr.store-vcard') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="qr_contact_type_id" class="form-select" required>
                                    <option value="" selected hidden>Select Contact Type</option>
                                    <option value="{{ $contact_type->id }}" selected>{{ $contact_type->name }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="user_id" class="form-select" required>
                                    <option value="" selected hidden>Select User</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->email }}</option>
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
                                <a href="{{ route('master-qr.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
