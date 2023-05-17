@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Management Supervisor'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-start justify-content-between pb-0">
                    <h6>Management Supervisor</h6>
                    <a href="{{ route('management-supervisor.create') }}" class="btn btn-info btn-sm">Create</a>
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
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Department Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Position
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Position Period
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Country
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Country Code
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Country Phone Code
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created at
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm font-weight-bold mb-0"></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
