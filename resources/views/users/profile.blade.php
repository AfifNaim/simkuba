@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Update Profile</h1>
        </div>

        <div class="section-body">
            <form method="post" action="{{ route('users.update_profile', $user->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $user->name }}"
                           type="text"
                           class="form-control"
                           name="name"
                           placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ $user->email }}"
                           type="email"
                           class="form-control"
                           name="email"
                           placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="{{ $user->username }}"
                           type="text"
                           class="form-control"
                           name="username"
                           placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update user</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </section>

@endsection
