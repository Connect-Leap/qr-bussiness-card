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
                        <form action="{{ route('master-qr.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="qr_contact_type_id" class="form-select">
                                    <option value="" selected hidden>Select Contact Type</option>
                                    @foreach($contact_types as $contact_type)
                                    <option value="{{ $contact_type->id }}" data-format-url="{{ $contact_type->format_link }}">{{ $contact_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="user_id" class="form-select">
                                    <option value="" selected hidden>Select User</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="redirect_link" class="form-control" placeholder="Redirect Link" aria-label="Redirect Link" value="">
                            </div>
                            <div class="mb-3">
                                <select name="usage_limit" class="form-select">
                                    <option value="" selected hidden>Select Scan Usage Limit</option>
                                    @forelse($settings as $setting)
                                    <option value="{{ $setting->default_scan_limit }}">{{ $setting->default_scan_limit }}</option>
                                    @empty
                                    <option value="3">3</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ route('master-qr.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                        <div class="alert alert-info">
                            <p class="fw-bold">Note : <br> Whatsapp = https://api.whatsapp.com/send?phone=your number here start from 62 </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $('select[name="qr_contact_type_id"]').change(function () {
        let formatUrl = $(this).find(':selected').data('format-url')

        $('input[name="redirect_link"]').val(formatUrl)
    })
</script>

@endpush
