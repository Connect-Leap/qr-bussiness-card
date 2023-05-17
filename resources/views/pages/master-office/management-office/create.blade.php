@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create Office'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Create Office</h6>
                    <a href="{{ route('management-office.index') }}" class="btn btn-info btn-sm">Back</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <form action="">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Office Name" aria-label="Office Name">
                            </div>
                            <div class="mb-3">
                                <textarea name="address" class="form-control" rows="5" placeholder="Office Address"></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Office Email" aria-label="Office Email">
                            </div>
                            <div class="mb-3">
                                <input type="number" name="contact" min="0" class="form-control" placeholder="Office Contact"
                                    aria-label="Office Contact">
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
