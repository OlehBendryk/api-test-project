@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Registration Token</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div>{{$token}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
