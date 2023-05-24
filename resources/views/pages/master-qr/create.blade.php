@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create your QR'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Create your QR</h6>
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
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="qr_contact_type_id" class="form-select">
                                    <option value="" selected hidden>Select Contact Type</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="user_id" class="form-select">
                                    <option value="" selected hidden>Select User</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="redirect_link" class="form-control" placeholder="Redirect Link" aria-label="Redirect Link">
                            </div>
                            <div class="mb-3">
                                <input type="number" min="1" name="usage_limit" class="form-control" placeholder="Number of Usage Limitation" aria-label="Default Rate Time Limit">
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
