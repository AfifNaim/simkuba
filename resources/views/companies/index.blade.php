@extends('layouts.app')

@section('title', 'UMKM')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>UMKM</h1>
        </div>

        <div class="section-body">
                <div class="mt-2">
                    @include('partials.message')
                </div>

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
                                        Halaman ini adalah Halaman UMKM yang terdaftar dalam Sistem Informasi Keuangan UMKM Batik di Masaran - Sragen
                                </div>
                            </div>
                </div>
                </div>
                <table class="table table-striped" style="width: 100%">
                    <thead>
                        <th width="1%">No</th>
                        <th>Name</th>
                        <th>Address</th>
                    </thead>
                    <tbody>
                    <?php $no = 0; ?>
                    @foreach ($companies as $company)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->address }}</td>
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


