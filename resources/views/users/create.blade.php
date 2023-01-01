@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header"> Create user</div>
            <div class="card-body">
                {{ Form::open([
                        'route' => 'users.store',
                        'method' => 'post',
                        'role' => 'form',
                        'enctype' => 'multipart/form-data',
                    ]) }}
                @csrf

                <div class="form-group row">
                    {{ Form::label('first_name', 'First Name', ['class' => 'col-4 text-md-right']) }}
                    {{ Form::text('first_name',null , ['class' => "form-control col-8" .  ($errors->has('first_name') ? 'is-invalid' : '')], 'required') }}
                    @if($errors->has('first_name'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('first_name') }}</strong>
                    @endif
                </div>

                <div class="form-group row">
                    {{ Form::label('last_name', 'Last Name', ['class' => 'col-4 text-md-right mt-2']) }}
                    {{ Form::text('last_name',null , ['class' => "form-control col-8" .  ($errors->has('last_name') ? 'is-invalid' : '')], 'required') }}
                    @if($errors->has('last_name'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('last_name') }}</strong>
                    @endif
                </div>

                <div class="form-group row">
                    {{ Form::label('gender', 'Gender', ['class' => 'col-4 text-md-right mt-2']) }}
                    {{ Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], ['class' => "form-control col-8" .  ($errors->has('gender') ? 'is-invalid' : ''), 'required']) }}
                    @if($errors->has('gender'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('gender') }}</strong>
                    @endif
                </div>

                <div class="form-group row">
                    {{ Form::label('email', 'Mail', ['class' => 'col-4 text-md-right mt-2']) }}
                    {{ Form::text('email',null , ['class' => "form-control col-8" .  ($errors->has('email') ? 'is-invalid' : '')], 'required') }}
                    @if($errors->has('email'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('email') }}</strong>
                    @endif
                </div>

                <div class="form-group row">
                    {{ Form::label('phone', 'Phone', ['class' => 'col-4 text-md-right mt-2']) }}
                    {{ Form::text('phone',null , ['class' => "form-control col-8" .  ($errors->has('phone') ? 'is-invalid' : '')], 'required') }}
                    @if($errors->has('phone'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('phone') }}</strong>
                    @endif
                </div>

                <div class="form-group row">
                    {{ Form::label('position_id', 'Positions', ['class' => 'col-4 text-md-right mt-2']) }}
                    {{ Form::select('position_id', $positions, ['class' => "form-control col-8" .  ($errors->has('position_id') ? 'is-invalid' : ''), 'required']) }}
                    @if($errors->has('position_id'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('position_id') }}</strong>
                    @endif
                </div>

                <div class="form-group row">
                    {{ Form::label('photo', 'Photo', ['class' => 'col-4 text-md-right mt-2']) }}
                    {{ Form::file('photo', ['class' => "form-control col-8" .  ($errors->has('photo') ? 'is-invalid' : ''), 'required']) }}
                    @if($errors->has('photo'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('photo') }}</strong>
                    @endif
                </div>

                <div class="form-group row">
                    {{ Form::label('token', 'Token', ['class' => 'col-4 text-md-right mt-2']) }}
                    {{ Form::text('token', $token , ['class' => "form-control col-8" .  ($errors->has('token') ? 'is-invalid' : '')], 'required') }}
                    @if($errors->has('token'))
                        <span class="invalid-feedback" role="alert"></span>
                        <strong> {{ $errors->first('token') }}</strong>
                    @endif
                </div>

                <div class="form-group mt-3 ">
                    {{ Form::submit('Create user', ['class' => 'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
