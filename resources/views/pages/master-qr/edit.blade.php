@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit your QR'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Edit your QR</h6>
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
                        <form action="{{ route('master-qr.update', $qr->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <select name="qr_contact_type_id" class="form-select">
                                    <option value="" selected hidden>Select Contact Type</option>
                                    @foreach($contact_types as $contact_type)
                                    <option value="{{ $contact_type->id }}" data-format-url="{{ $contact_type->format_link }}" @selected(old('qr_contact_type_id', $contact_type->id) == $qr->qr_contact_type_id)>{{ $contact_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="user_id" class="form-select">
                                    <option value="" selected hidden>Select User</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id', $user->id) == $qr->user_id)>{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="redirect_link" class="form-control {{ session()->has('fail') ? 'is-invalid' : '' }}" placeholder="Redirect Link" aria-label="Redirect Link" value="{{ old('redirect_link', $qr->redirect_link) }}">
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="number" value="{{ $qr->usage_limit }}" name="usage_limit" readonly>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ route('master-qr.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                        <div class="alert alert-info">
                            <p class="fw-bold">Note : <br> Whatsapp = https://api.whatsapp.com/send?phone=your number here start from 62 <br> Your Current Redirect Link : {{ $qr->redirect_link }} <br> Your Current Contact Type : {{ $qr->qrContactType->name }}</p>
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
