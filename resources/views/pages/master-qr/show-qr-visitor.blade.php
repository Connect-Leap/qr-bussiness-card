@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Detail QR Code'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0 mb-3">
                    <h6>Detail QR Code</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('master-qr.index') }}" class="btn btn-info btn-sm">Back</a>
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
                                                                <ul class="text-start">
                                                                    <li>{{ 'Country Name : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->country_name }}</li>
                                                                    <li>{{ 'Country Code : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->country_code }}</li>
                                                                    <li>{{ 'Region Code : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->region_code }}</li>
                                                                    <li>{{ 'Region Name : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->region_name }}</li>
                                                                    <li>{{ 'City Name : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->city_name }}</li>
                                                                    <li>{{ 'Zip Code : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->zip_code }}</li>
                                                                    <li>{{ 'Latitude : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->latitude }}</li>
                                                                    <li>{{ 'Longitude : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->longitude }}</li>
                                                                    <li>{{ 'Area Code : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->area_code }}</li>
                                                                    <li>{{ 'Timezone : '.json_decode($qr_visitor->detail_visitor_json)->visitor_location_data->timezone }}</li>
                                                                    <li>{{ 'Device Name : '.json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->device_name }}</li>
                                                                    <li>{{ 'Operating System : '.json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->operating_system_name }}</li>
                                                                    <li>{{ 'Browser : '.json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->browser_name }}</li>
                                                                    <li>{{ 'Is Robot ? : '.(json_decode($qr_visitor->detail_visitor_json)->visitor_internet_data->is_robot == false ? 'No' : 'Yes') }}</li>
                                                                </ul>
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
