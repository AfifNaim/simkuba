@extends('layouts.app')

@section('title', 'Kategori')

@push('stylesheet')
    <style>
        table {
            width: 100%;
        }
    </style>
@endpush

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Kategori</h1>
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
                                        Halaman ini adalah Halaman Kategori yang berfungsi untuk memfilter transaksi, terdapat 2 jenis kategori pemasukan dan pengeluaran. Disini juga terdapat kategori default yang dibuat oleh Admin
                                </div>
                            </div>
                </div>
        </div>
        
        <div class="section-body">
            <button type="button" class="btn btn-primary mb-4" onclick="showAddForm()">
                Tambah Kategori
            </button>

            @include('partials.message')
            
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item text-center" style="width: 50%">
                    <a class="nav-link text-dark active" id="income-tab" data-toggle="tab" href="#income" role="tab" aria-controls="income" aria-selected="true">Kategori Pemasukan</a>
                </li>
                <li class="nav-item text-center" style="width: 50%">
                    <a class="nav-link text-dark" id="expense-tab" data-toggle="tab" href="#expense" role="tab" aria-controls="expense" aria-selected="false">Kategori Pengeluaran</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="income" role="tabpanel" aria-labelledby="income-tab">
                    <table class="table table-striped incomeCategories" style="width: 100%">
                        <thead>
                        <th width="5%" class="text-center">No</th>
                        <th>Kategori</th>
                        <th>Ditambahkan Oleh</th>
                        <th class="text-center">Action</th>
                        </thead>
                        <?php $i = 0; ?>
                        <tbody>
                        @foreach ($incomeCategories as $category)
                            <tr>
                                <td width="5%" class="text-center">{{ ++$i }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->user->name ?? 'Default' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
                                            @role('Admin')
                                                <a class="btn btn-primary btn-sm text-white" onclick="showEditForm({{ $category->id }})">Edit</a>
                                                @if($category->cash_book_count == 0)
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                                @endif
                                            @endrole
                                            @hasanyrole('Manager|Employe')
                                                @if($category->company_id)
                                                    <a class="btn btn-primary btn-sm text-white" onclick="showEditForm({{ $category->id }})">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                                @endif
                                            @endhasanyrole
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                    <table class="table table-striped incomeCategories" style="width: 100%">
                        <thead>
                        <th width="5%" class="text-center">No</th>
                        <th>Kategori</th>
                        <th>Ditambahkan Oleh</th>
                        <th class="text-center">Action</th>
                        </thead>
                        <?php $i = 0; ?>
                        <tbody>
                        @foreach ($expanseCategories as $category)
                            <tr>
                                <td width="5%" class="text-center">{{ ++$i }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->user->name ?? 'Default' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
                                        @role('Admin')
                                        <a class="btn btn-primary btn-sm text-white" onclick="showEditForm({{ $category->id }})">Edit</a>
                                        @if($category->cash_book_count == 0)
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                        @endif
                                        @endrole
                                        @hasanyrole('Manager|Employe')
                                        @if($category->company_id)
                                            <a class="btn btn-primary btn-sm text-white" onclick="showEditForm({{ $category->id }})">Edit</a>
                                            @if($category->cash_book_count == 0)
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                            @endif
                                        @endif
                                        @endhasanyrole
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @include('partials.modal')

@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            $('.incomeCategories').DataTable();
            $('.expanseCategories').DataTable();
        });

        function showAddForm() {
            $.ajax({
                type: "GET",
                url: "{{ route('categories.create') }}",
                dataType: 'html'
            }).done(function(response) {
                $('#modal').modal({backdrop: 'static', keyboard: false})
                $('.modal-content').html(response)
            });
        }

        function showEditForm(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('categories') }}/"+id+"/edit",
                dataType: 'html'
            }).done(function(response) {
                $('#modal').modal('show')
                $('.modal-content').html(response)
            });
        }
    </script>
@endpush
