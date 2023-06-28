@extends('layouts.app')

@push('app')

<style>
    .modal-dialog {
        max-width: 70%;
        width: auto !important;
        margin-right: 80px;
    }
</style>

@endpush

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Detail QR Code'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0 mb-3">
                    <h6>Detail QR Code</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ (request()->segment(2) == "general-qr") ? route('general-qr.index') : route('master-qr.index') }}" class="btn btn-info btn-sm">Back</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="table-responsive p-0">
                            <table class="table datatable-jquery align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">IP Address</th>
                                        <th class="text-center">Detail Visitor</th>
                                        <th class="text-center">Access Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($qr_model->qrVisitors as $qr_visitor)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">#</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $qr_visitor->ip_address }}</p>
                                            </td>
                                            <td class="text-center">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{$loop->index + 1}}">
                                                    Click For Show Detail QR Visitor
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{$loop->index + 1}}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">QR Visitor Detail</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive p-0 mx-2 my-2 pb-2">
                                                                    <table style="border: 2px solid black">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Country Name
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Country Code
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Region Code
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Region Name
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    City Name
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Zip Code
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Latitude - Longitude
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Area Code
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Timezone
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Device Type
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Device Name
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Operating System
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Browser
                                                                                </th>
                                                                                <th style="border: 2px solid black" class="text-center text-dark">
                                                                                    Is Robot
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->country_name }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->country_code }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->region_code }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->region_name }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->city_name }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->zip_code }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->latitude.' - '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->longitude }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->area_code }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->timezone }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->device_type }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->device_name }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->operating_system_name }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->browser_name }}
                                                                                </td>
                                                                                <td style="border: 2px solid black" class="text-center text-dark">
                                                                                    {{ (json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->is_robot == false ? 'No' : 'Yes') }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
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
                                                <p class="text-sm font-weight-bold mb-0">{{ $qr_visitor->created_at }}</p>
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
