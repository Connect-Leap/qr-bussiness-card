@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Checkout Payment'])
    <div class="row justify-content-center mt-5 mx-4">
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Checkout Payment</h6>
                    <a href="{{ route('information-setting.index') }}" class="btn btn-xs btn-info text-white">Back</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        @if (Session::has('errors'))
                            <div class="my-2">
                                <div class="alert alert-warning">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-light fw-bold">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('information-setting.checkout-order') }}" method="POST">
                            @csrf

                            <input type="hidden" name="checkout_data_json" id="collect-data">
                            <input type="hidden" name="information_setting_id" value="">

                            <div class="my-4">
                                <input type="text" name="voucher_code" class="form-control"
                                    placeholder="Voucher Code (Optional)" aria-label="Voucher Code"
                                    value="{{ old('voucher_code') }}">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-info">Checkout Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
