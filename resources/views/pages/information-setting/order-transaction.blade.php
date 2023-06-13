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
                        <form action="{{ route('information-setting.checkout-order') }}" method="POST" id="post-data">
                            @csrf

                            <input type="hidden" name="checkout_data_json" id="collect-data">
                            <input type="hidden" name="information_setting_id" value="{{ $information_setting->id }}">

                            <div class="my-4">
                                <input type="text" name="voucher_code" class="form-control"
                                    placeholder="Voucher Code (Optional)" aria-label="Voucher Code"
                                    value="{{ old('voucher_code') }}" disabled>
                            </div>
                        </form>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-info" id="pay-button">Checkout Payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('app')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
@endpush

@if (!is_null($information_setting->stakeholder_email))
@push('js')
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay("{{ $midtrans['snap_token'] }}", {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    console.log(result);
                    retrieveDataToForm(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    console.log(result);
                    retrieveDataToForm(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    console.log(result);
                    retrieveDataToForm(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });

        function retrieveDataToForm(result) {
            let data = document.getElementById('collect-data').value = JSON.stringify(result);
            $('#post-data').submit();
        }
    </script>
@endpush
@endif
