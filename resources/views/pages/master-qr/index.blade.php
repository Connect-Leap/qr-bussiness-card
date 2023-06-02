@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'QR Configuration'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0 mb-3">
                    <h6>QR Configuration</h6>
                    <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-warning" href="{{ route('master-qr.reset-all-user-qr-code') }}">Reset All Usage Limit</a>
                        <a href="{{ route('master-qr.create') }}" class="btn btn-info btn-sm">Create your QR</a>
                        <a href="{{ route('master-qr.create-vcard') }}" class="btn btn-info btn-sm">Create your QR with VCard</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="table-responsive p-0">
                            <table class="table datatable-jquery align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Contact Type</th>
                                        <th class="text-center">Office</th>
                                        <th class="text-center">QR Owner (User)</th>
                                        <th class="text-center">Show QR</th>
                                        <th class="text-center">Usage Limit Remain</th>
                                        <th class="text-center">QR Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($qrcodes as $qrcode)
                                        <tr>
                                            <td class="text-center">#</td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $qrcode['qrcode']['qr_contact_types']['qr_contact_type']['name'] }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $qrcode['qrcode']['users']['office_name'] }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $qrcode['qrcode']['users']['email'] }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{$loop->index + 1}}">
                                                    Click for Show QR Code
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{$loop->index + 1}}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Scan Here</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if(!is_null($qrcode['qrcode']['redirect_link']))
                                                                {!! QrCode::size(300)->generate(route('master-qr.qr-processing', [
                                                                    'urlkey' => $qrcode['short_url']['url_key'],
                                                                    'qr_id' => $qrcode['qrcode']['id'],
                                                                ])) !!}
                                                                @else
                                                                {!! QrCode::size(300)->generate(route('master-qr.qr-vcard-processing', [
                                                                    'qr_id' => $qrcode['qrcode']['id']
                                                                ])) !!}
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $qrcode['qrcode']['usage_limit'] }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge {{ $qrcode['qrcode']['status'] == 'valid' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($qrcode['qrcode']['status']) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-xs btn-info" href="{{ route('master-qr.reset-user-qr-code', $qrcode['qrcode']['id']) }}">Reset</a>
                                                <a href="{{ route('master-qr.show-detail-qr', $qrcode['qrcode']['id']) }}" class="btn btn-xs btn-secondary">Detail</a>
                                                @if(!is_null($qrcode['qrcode']['redirect_link']))
                                                <a class="btn btn-xs btn-success" href="{{ route('master-qr.edit', $qrcode['qrcode']['id']) }}">Edit</a>
                                                @endif
                                                <a href="{{ route('master-qr.destroy', $qrcode['qrcode']['id']) }}" class="btn btn-xs btn-danger btn-delete">Delete</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">Empty Data</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
