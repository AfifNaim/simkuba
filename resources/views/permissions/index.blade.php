@extends('layouts.app')

@section('title', 'Permission')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Permissions</h1>
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
                                        Halaman ini adalah Halaman Permission yang berisi Akses apa saya yang terdapat pada Sistem
                                </div>
                            </div>
                </div>
        </div>

            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-md mb-4">Add new permission</a>
            <div class="mt-2">
                @include('partials.message')
            </div>

            <table class="table table-striped" style="width: 100%">
                <thead>
                    <th scope="col" width="1%">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Guard</th>
                    <th scope="col" style="text-align: center">Aksi</th>
                </thead>
                <tbody>
                <?php $no = 0; ?>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td style="text-align: center">
                            <form action="{{ route('permissions.destroy',$permission->id) }}" method="POST">
                                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm">Edit</a>
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
