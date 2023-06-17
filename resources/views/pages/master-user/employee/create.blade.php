@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create Employee'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Create Employee</h6>
                    <a href="{{ route('management-employee.index') }}" class="btn btn-info btn-sm">Back</a>
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
                        <form action="{{ route('management-employee.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="office_id" class="form-select">
                                    <option value="" selected hidden>Office</option>
                                    @foreach($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <input type="text" name="name" class="form-control" placeholder="User Name" aria-label="User Name" value="{{ old('name') }}">
                                </div>
                                <div class="col-6">
                                    <select name="gender" class="form-select">
                                        <option value="" selected hidden>Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <input type="email" name="email" class="form-control" placeholder="User Email" aria-label="User Email" value="{{ old('email') }}">
                                </div>
                                <div class="col-6">
                                    <input type="password" name="password" class="form-control" placeholder="User Password" aria-label="User Password" value="{{ old('password') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone_number" class="form-control" placeholder="Employee Phone Number" aria-label="Employee Phone Number" min="9" max="13" value="{{ old('phone_number') }}">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="employee_code" class="form-control" placeholder="Employee Code" aria-label="Employee Code" value="{{ old('employee_code') }}">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="department_name" class="form-control" placeholder="Department Name" aria-label="Department Name" value="{{ old('department_name') }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <input type="text" name="user_position" class="form-control" placeholder="Employee Position" aria-label="Employee Position" value="{{ old('user_position') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="user_position_period" class="form-control" placeholder="Employee Position Year Period (2022, 2023, etc)" aria-label="Employee Position Year Period (2022, 2023, etc)" value="{{ old('user_position_period') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="country_name" class="form-control" placeholder="Country Name"
                                    aria-label="Country Name" value="{{ old('country_name') }}">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="country_code" class="form-control" placeholder="Country Code (JPN, INA, etc)"
                                    aria-label="Country Code" value="{{ old('country_code') }}">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="country_phone_code" class="form-control" placeholder="Country Phone Code (+62, etc)"
                                    aria-label="Country Name" value="{{ old('country_phone_code') }}">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ route('management-office.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
