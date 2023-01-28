@extends('layouts.app')

@section('title', 'Detail Role')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Role</h1>
        </div>

        <div class="section-body">
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm mb-4">Add new role</a>

            <table class="table table-striped">
                <thead>
                <th scope="col" width="20%">Name</th>
                <th scope="col" width="1%">Guard</th>
                </thead>

                @foreach($rolePermissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="mt-4">
            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info">Edit</a>
            <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
        </div>
    </section>
@endsection
