@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Update Role</h1>
        </div>

        <div class="section-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $role->name }}"
                           type="text"
                           class="form-control"
                           name="name"
                           placeholder="Name" required>
                </div>

                <label for="permissions" class="form-label">Assign Permissions</label>

                <table class="table table-striped" style="width: 100%">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                        <th scope="col" width="20%">Name</th>
                        <th scope="col" width="1%">Guard</th>
                    </thead>

                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>
                                <input type="checkbox"
                                       name="permission[{{ $permission->name }}]"
                                       value="{{ $permission->name }}"
                                       class='permission'
                                    {{ in_array($permission->name, $rolePermissions)
                                        ? 'checked'
                                        : '' }}>
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>
    </section>
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }

            });
        });
    </script>
@endpush
