@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
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
                                        Halaman ini adalah Halaman Users yang berisi User yang terdaftar pada sistem
                                </div>
                            </div>
                </div>
        </div>

            <a href="{{ route('users.create') }}" class="btn btn-primary btn-md mb-4">Add new user</a>

            <div class="mt-2">
                @include('partials.message')
            </div>

            <table class="table table-striped" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col" width="1%">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Roles</th>
                    <th scope="col" style="text-align: center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 0 ?>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ ++$no }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-warning text-white">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td style="text-align: center">
                            <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
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
