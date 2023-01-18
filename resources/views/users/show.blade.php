@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>User #{{$user->id}}</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div> ID - {{$user->id}}</div>
                        <div> First Name - {{$user->first_name}}</div>
                        <div> Last Name - {{$user->last_name}}</div>
                        <div> Gender - {{$user->gender}}</div>
                        <div> Email - {{$user->email}}</div>
                        <div> Phone - {{$user->phone}}</div>
                        <div> Photo - {{$user->photo}}</div>
                        <div> Position - {{$user->position->name}}</div>
                    </div>

                    <div class="col-4 text-right">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>

                        <div class="mt-2">
                            <form action="{{ route('users.destroy', $user) }}" method="post" >
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas faw fa-trash-alt "></i>  Remove
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
