@extends('layouts.master')

@section('content')
    <div class="container">


        <div class="row pt-3 pb-3 mb-3 border-bottom">
            <div class="col-6">
                {{--            <h2> Users - {{ $users->count() }}</h2>--}}
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>Create user
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-9">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>user</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <a href="{{ route('users.show', $user) }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </a>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{--                Pagination --}}

                <div class="d-flex justify-content-end">
                    {{ $users->links() }}
                </div>
            </div>
        </div>


    </div>

@endsection
