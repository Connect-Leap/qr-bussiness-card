@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Management Office'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Management Office</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        #
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Office Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Office Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Office Contact
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Show Employee
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($offices as $office)
                                <tr>
                                    <td class="text-center">
                                        #
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0">{{ $office->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0">{{ $office->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0">{{ $office->contact }}</p>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('detail-master-office.show-employee', $office->id) }}" class="btn btn-xs btn-success">Show Related Employee</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Empty Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
