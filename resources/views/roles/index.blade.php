@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Roles</h1>
        </div>

        <div class="section-body">

        <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                            <div class="card " id="mycard-dimiss">
                                <div class="card-header">
                                    <h4>Informasi Halaman</h4>
                                    <div class="card-header-action">
                                        <a data-dismiss="#mycard-dimiss" class="btn btn-icon btn-danger" href="#"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                        Halaman ini adalah Halaman Role yang berisi Role yang terdapat pada sistem, terdiri dari role Admin, Manajer, dan User
                                </div>
                            </div>
                </div>
        </div>

            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-md mb-4">Add new role</a>

            <div class="mt-2">
                @include('partials.message')
            </div>

            <table class="table table-striped" style="width: 100%">
                <thead>
                    <th width="1%">No</th>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th style="text-align: right">Aksi</th>
                </thead>
                <tbody>
                <?php $no = 0; ?>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach($role->permissions as $permission)
                                <span class="badge bg-warning text-white">{{ $permission->name }}</span>
                            @endforeach
                        </td>
                        <td style="text-align: right">
                            <form action="{{ route('roles.destroy',$role->id) }}" method="POST">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            $('.table').DataTable();
        });
    </script>
@endpush


