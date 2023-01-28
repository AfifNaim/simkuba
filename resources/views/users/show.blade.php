@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mt-5 mb-5">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h1>User Detail</h1>
                    </div>
                    <div class="float-right">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Add new user</a>
                    </div>
                </div>
            </div>

            <div>
                Name: {{ $user->name }}
            </div>
            <div>
                Email: {{ $user->email }}
            </div>
            <div>
                Username: {{ $user->username }}
            </div>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
