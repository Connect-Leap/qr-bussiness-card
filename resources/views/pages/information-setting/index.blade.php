@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Information Setting'])
    <div class="row justify-content-center mt-5 mx-4">
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Information Setting</h6>
                    <form action="{{ route('information-setting.checkout-order') }}" method="POST" id="post-data">
                        @csrf
                        <input type="hidden" name="checkout_data_json" id="collect-data">
                        <input type="hidden" name="information_setting_id" value="{{ $information_setting->id }}">
                    </form>
                    <button id="pay-button" class="btn btn-xs btn-primary text-white"
                        {{ !is_null($information_setting->stakeholder_email) ? '' : 'disabled' }}>Extend Expired
                        Date</button>
                    <a href="{{ route('information-setting.order-page') }}" class="btn btn-xs btn-primary text-white">Extend Expired Date</a>
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
                        <form action="{{ route('information-setting.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="my-4">
                                <input type="text" name="application_name" class="form-control"
                                    placeholder="Application Name" aria-label="Application Name"
                                    value="{{ old('application_name', $information_setting->application_name) }}">
                            </div>

                            <div class="my-4">
                                <input type="text" name="application_version" class="form-control"
                                    placeholder="Application Version" aria-label="Application Version"
                                    value="{{ old('application_version', $information_setting->application_version) }}"
                                    readonly>
                            </div>

                            <div class="my-4">
                                <textarea name="application_description" rows="3" placeholder="Application Description" class="form-control">{{ old('application_description', $information_setting->application_description) }}</textarea>
                            </div>

                            <div class="my-4">
                                <input type="email" class="form-control" placeholder="Stakeholder Email"
                                    aria-label="Stakeholder Email"
                                    value="{{ old('stakeholder_email', $information_setting->stakeholder_email) }}"
                                    name="stakeholder_email">
                                @if (is_null($information_setting->stakeholder_email))
                                    <small class="text-danger">please fill these column to verified this application is
                                        yours</small>
                                @endif
                            </div>

                            <div class="my-4">
                                <input type="text" class="form-control" placeholder="Expired Date"
                                    aria-label="Expired Date"
                                    value="{{ (!is_null($information_setting->expired_date)) ? $day_counter : '' }}" disabled>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </form>
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
