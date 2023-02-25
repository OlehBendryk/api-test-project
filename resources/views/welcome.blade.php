@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="page-header"><h1>Test Api Assignment </h1></div>

                <div class="card mt-2 mb-2">
                    <h5 class="card-header">/token</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="m-0">
                                <a href="{{route('registration.token')}}">/token</a></p>
                            <a href="{{route('registration.token')}}" class="btn btn-primary ms-auto">Get</a>
                        </div>
                    </div>
                </div>

                <div class="card mt-2 mb-2">
                    <h5 class="card-header">/users</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="m-0">
                                <a href="{{route('users.index')}}">/users</a></p>
                            <a href="{{route('users.index')}}" class="btn btn-primary ms-auto me-2">Get</a>
                            <a href="{{route('users.create')}}" class="btn btn-success ">Post</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <p class="m-0">
                                Returns users data in json, where <b>page</b> - current page,
                                <b>count</b> - quantities users on page
                            </p>
                            <a href="{{route('user.api.index').'?page=1&count=5'}}" class="btn btn-warning ">JSON</a>

                        </div>
                    </div>
                </div>

                <div class="card mt-2 mb-2">
                    <h5 class="card-header">/users/{id}</h5>
                    <div class="card-body">
                        For example, returns a user with ID=1
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="m-0">
                                <a href="{{route('users.show', 1)}}">/users/{1}</a></p>
                            <a href="{{route('users.show', 1)}}" class="btn btn-primary ms-auto">Get</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <p class="m-0">
                                <a href="{{route('user.api.show', 1)}}">/users/{1}</a></p>
                            <a href="{{route('user.api.show', 1)}}" class="btn btn-warning ms-auto">JSON</a>
                        </div>
                    </div>
                </div>

                <div class="card mt-2 mb-2">
                    <h5 class="card-header">/positions</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="m-0">
                                <a href="{{route('positions.api.index')}}">/positions</a></p>
                            <a href="{{route('positions.api.index')}}" class="btn btn-primary ms-auto">Get</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection()
