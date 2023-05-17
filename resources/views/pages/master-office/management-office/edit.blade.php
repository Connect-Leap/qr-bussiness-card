@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Office'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Edit Office</h6>
                    <a href="{{ route('management-office.index') }}" class="btn btn-info btn-sm">Back</a>
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
                        <form action="{{ route('management-office.update', $office->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Office Name" aria-label="Office Name" value="{{ old('name', $office->name) }}">
                            </div>
                            <div class="mb-3">
                                <textarea name="address" class="form-control" rows="5" placeholder="Office Address">{{ old('address', $office->address) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Office Email" aria-label="Office Email" value="{{ old('email', $office->email) }}">
                            </div>
                            <div class="mb-3">
                                <input type="number" name="contact" min="0" class="form-control" placeholder="Office Contact"
                                    aria-label="Office Contact" value="{{ old('contact', $office->contact) }}">
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
