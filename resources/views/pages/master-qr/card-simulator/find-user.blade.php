@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create your Card Preview'])
    <div class="row justify-content-center mt-5 mx-4">
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Find User - Card Preview</h6>
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
                        <form action="{{ route('card-simulator.show') }}">
                            @csrf
                            <div class="my-4">
                                <select name="user_id" class="form-select" required>
                                    <option value="" selected hidden>Select User</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="my-4">
                                <select name="card_theme" class="form-select">
                                    <option value="" selected hidden>Select Theme</option>
                                    <option value="light">Light Theme</option>
                                    <option value="dark">Dark Theme</option>
                                </select>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-info">I Want to See The Card Simulation :)</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
