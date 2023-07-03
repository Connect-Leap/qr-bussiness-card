@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Employee'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Edit Employee</h6>
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
                        <form action="{{ route('management-employee.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <select name="office_id" class="form-select" required>
                                    <option value="" selected hidden>Office</option>
                                    @foreach($offices as $office)
                                    <option value="{{ $office->id }}" @selected(old('office_id', $user->office->id) == $office->id)>{{ $office->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <input type="text" name="name" class="form-control" placeholder="User Name" aria-label="User Name" value="{{ old('name', $user->employee->name) }}" required>
                                </div>
                                <div class="col-6">
                                    <select name="gender" class="form-select" required>
                                        <option value="" selected hidden>Gender</option>
                                        <option value="male" @selected(old('gender', $user->gender) == 'male')>Male</option>
                                        <option value="female" @selected(old('gender', $user->gender) == 'female')>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="email" name="email" class="form-control" placeholder="User Email" aria-label="User Email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone_number" class="form-control" placeholder="Employee Phone Number" aria-label="Employee Phone Number" min="9" max="13" value="{{ old('phone_number', $user->phone_number) }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="employee_code" class="form-control" placeholder="Employee Code" aria-label="Employee Code" value="{{ old('employee_code', $user->employee->employee_code) }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="department_name" class="form-control" placeholder="Department Name" aria-label="Department Name" value="{{ old('department_name', $user->department->name) }}" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <input type="text" name="user_position" class="form-control" placeholder="Employee Position" aria-label="Employee Position" name="user_position" value="{{ old('user_position', $user->position->name) }}" required>
                                </div>
                                <div class="col-6">
                                    <input type="number" name="user_position_period" class="form-control" placeholder="Employee Position Year Period (2022, 2023, etc)" aria-label="Employee Position Year Period (2022, 2023, etc)" value="{{ old('user_position_period', $user->position->period) }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <select name="country_id" class="form-select" required>
                                    <option value="" selected hidden>Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @selected(old('country_id', $user->country->id) == $country->id)>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info">Update</button>
                                <a href="{{ route('management-office.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
