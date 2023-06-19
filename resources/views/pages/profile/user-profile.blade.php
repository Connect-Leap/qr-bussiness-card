@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div class="row mt-4 mx-3">
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Online Hour</p>
                                <h6 class="font-weight-bolder">
                                    {{ $total_online_hour }}
                                </h6>
                                <p class="mb-0">
                                    Login at
                                    <span class="text-success text-sm font-weight-bolder">{{ $user->login_at }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Usage Hour</p>
                                <h6 class="font-weight-bolder">
                                    {{ $total_usage_hour }}
                                </h6>
                                <p class="mb-0">
                                    Since Registered at
                                    <span class="text-success text-sm font-weight-bolder">{{ $user->created_at }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-lg mx-4 mt-5">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ asset('img/team-1.jpg') }}" alt="profile_image"
                            class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $user->hasRole('admin') ? $user->admin->name : ($user->hasRole('supervisor') ? $user->supervisor->name : $user->employee->name) }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $user->position->name }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="btn-tab nav-item" id="user-profile-tab">
                                <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                    <i class="fa fa-user"></i>
                                    <span class="ms-2">Profile</span>
                                </a>
                            </li>
                            @if(!$user->hasRole('admin'))
                            <li class="btn-tab nav-item" id="card-simulation-tab">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="fa fa-id-card"></i>
                                    <span class="ms-2">Card Simulation</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">

        <div class="row" id="user-profile-section">
            <div class="col-md-12">
                <div class="card">
                    @if (Session::has('errors'))
                        <div class="my-3 mx-3">
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-light fw-bold">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 fw-bold">Edit Profile</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                @if (!$user->hasRole('admin'))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Office Name</label>
                                            <input type="text" class="form-control" value="{{ $user->office->name }}"
                                                disabled>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="User Name"
                                            aria-label="User Name" value="{{ old('name', $user->hasRole('admin') ? $user->admin->name : ($user->hasRole('supervisor') ? $user->supervisor->name : $user->employee->name)) }}" {{ $user->hasRole('admin') ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input type="email" name="email" class="form-control" placeholder="User Email"
                                            aria-label="User Email" value="{{ old('email', $user->email) }}"
                                            {{ $user->hasRole('admin') ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Gender</label>
                                        <input type="text" name="gender" class="form-control" placeholder="Gender"
                                            aria-label="Gender" value="{{ old('phone_number', $user->gender) }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Contact Information</p>
                            <div class="row">
                                @if ($user->hasRole('employee'))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone
                                                Number</label>
                                            <input type="tel" name="phone_number" class="form-control"
                                                placeholder="Employee Phone Number" aria-label="Employee Phone Number"
                                                min="9" max="13"
                                                value="{{ old('phone_number', $user->phone_number) }}">
                                        </div>
                                    </div>
                                @endif
                                @if ($user->hasRole('employee'))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Employee
                                                Code</label>
                                            <input type="text" name="employee_code" class="form-control"
                                                placeholder="Employee Code" aria-label="Employee Code"
                                                value="{{ old('employee_code', $user->employee->employee_code) }}">
                                        </div>
                                    </div>
                                @endif
                                @if (!$user->hasRole('admin'))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Department
                                                Name</label>
                                            <input type="text" name="department_name" class="form-control"
                                                placeholder="Department Name" aria-label="Department Name"
                                                value="{{ old('department_name', $user->department->name) }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Employee Position</label>
                                        <input type="text" name="user_position" class="form-control" placeholder="Employee Position" aria-label="Employee Position" value="{{ old('user_position', $user->position->name) }}" {{ $user->hasRole('admin') ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Employee Period</label>
                                        <input type="number" name="user_position_period" class="form-control"
                                            placeholder="Employee Position Year Period (2022, 2023, etc)"
                                            aria-label="Employee Position Year Period (2022, 2023, etc)"
                                            value="{{ old('user_position_period', $user->position->period) }}"
                                            {{ $user->hasRole('admin') ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country Name</label>
                                        <input type="text" name="country_name" class="form-control"
                                            placeholder="Country Name" aria-label="Country Name"
                                            value="{{ old('country_name', $user->nationality->country_name) }}"
                                            {{ $user->hasRole('admin') ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country Code</label>
                                        <input type="text" name="country_code" class="form-control"
                                            placeholder="Country Code (JPN, INA, etc)" aria-label="Country Code"
                                            value="{{ old('country_code', $user->nationality->country_code) }}"
                                            {{ $user->hasRole('admin') ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country Phone Code</label>
                                        <input type="text" name="country_phone_code" class="form-control"
                                            placeholder="Country Phone Code (+62, etc)" aria-label="Country Name"
                                            value="{{ old('country_phone_code', $user->nationality->country_phone_code) }}"
                                            {{ $user->hasRole('admin') ? 'readonly' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mx-4 pb-3">
                            <button type="submit" class="btn btn-primary btn-sm text-white"
                                {{ $user->hasRole('admin') ? 'disabled' : '' }}>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(!$user->hasRole('admin'))
        <div class="row" id="card-simulation-section">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Card Simulation</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-8">
                                <x-card-view :user="$user" :qr="$qr" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


        {{-- Footer --}}
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script>
        $('#card-simulation-section').hide()

        $('li.btn-tab').click(function() {
            let tabId = $(this).attr('id')

            if (tabId == "user-profile-tab") {
                showProfileSection()
            } else {
                showCardSimulationSection()
            }
        })

        function showProfileSection() {
            $('#card-simulation-section').hide()
            $('#user-profile-section').fadeIn(700)
        }

        function showCardSimulationSection() {
            $('#user-profile-section').hide()
            $('#card-simulation-section').fadeIn(700)
        }
    </script>
@endpush
