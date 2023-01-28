@extends('layouts.app')

@section('title', 'Pembukuan')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pembukuan</h1>
        </div>

        <div class="section-body">
            @include('partials.message')
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
                                Halaman ini adalah Pembukuan yang berisi data Transaksi Pembukuan UMKM
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item text-center" style="width: 50%">
                    <a class="nav-link text-dark active" id="income-tab" data-toggle="tab" href="#income" role="tab" aria-controls="income" aria-selected="true">Pemasukan<span><br/><h4 class="text-success">Rp{{ number_format($sumIncome, 0, ',', '.') }}</h4></span></a>
                </li>
                <li class="nav-item text-center" style="width: 50%">
                    <a class="nav-link text-dark" id="expense-tab" data-toggle="tab" href="#expense" role="tab" aria-controls="expense" aria-selected="false">Pengeluaran<span><br/><h4 class="text-danger">Rp{{ number_format($sumExpanse, 0, ',', '.') }}</h4></span></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="income" role="tabpanel" aria-labelledby="income-tab">
                    <div class="float-right mt-4 mb-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" onclick="showAddForm('K')">
                            Tambah Pemasukan
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-md incomeCategories" style="width: 100%">
                            <thead>
                            <th width="5%" class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Action</th>
                            </thead>
                            <?php $i = 0; ?>
                            <tbody>
                            @foreach ($cashBooks as $cashBook)
                                @if($cashBook->category->type == "K")
                                    <tr>
                                        <td width="5%" class="text-center">{{ ++$i }}</td>
                                        <td>{{ $cashBook->date }}</td>
                                        <td>{{ $cashBook->category->name }}</td>
                                        <td>Rp{{ number_format($cashBook->amount, 0, ',', '.') }}</td>
                                        <td>{{ $cashBook->qty }}</td>
                                        <td>Rp{{ number_format($cashBook->summary, 0, ',', '.') }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($cashBook->description, 10) }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('cash-books.destroy',$cashBook->id) }}" method="POST">
                                                <a class="btn btn-info btn-sm text-white" onclick="showDetail({{ $cashBook->id }})">Detail</a>
                                                <a class="btn btn-primary btn-sm text-white" onclick="showEditForm({{ $cashBook->id }}, 'K')">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                    <div class="float-right mt-4 mb-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" onclick="showAddForm('D')">
                            Tambah Pengeluaran
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped expanseCategories" style="width: 100%">
                            <thead>
                            <th width="5%" class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Action</th>
                            </thead>
                            <?php $i = 0; ?>
                            <tbody>
                            @foreach ($cashBooks as $cashBook)
                                @if($cashBook->category->type == "D")
                                    <tr>
                                        <td width="5%" class="text-center">{{ ++$i }}</td>
                                        <td>{{ $cashBook->date }}</td>
                                        <td>{{ $cashBook->category->name }}</td>
                                        <td>Rp{{ number_format($cashBook->amount, 0, ',', '.') }}</td>
                                        <td>{{ $cashBook->qty }}</td>
                                        <td>Rp{{ number_format($cashBook->summary, 0, ',', '.') }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($cashBook->description, 10) }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('cash-books.destroy',$cashBook->id) }}" method="POST">
                                                <a class="btn btn-info btn-sm text-white" onclick="showDetail({{ $cashBook->id }})">Detail</a>
                                                <a class="btn btn-primary btn-sm text-white" onclick="showEditForm({{ $cashBook->id }}, 'D')">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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

        function showAddForm(type) {
            $.ajax({
                type: "GET",
                url: "{{ url('cash-books') }}/create?type="+type,
                dataType: 'html'
            }).done(function(response) {
                $('#modal').modal({backdrop: 'static', keyboard: false})
                $('.modal-content').html(response)
            });
        }

        function showEditForm(id, type) {
            $.ajax({
                type: "GET",
                url: "{{ url('cash-books') }}/"+id+"/edit?type="+type,
                dataType: 'html'
            }).done(function(response) {
                $('#modal').modal({backdrop: 'static', keyboard: false})
                $('.modal-content').html(response)
            });
        }

        function showDetail(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('cash-books') }}/"+id,
                dataType: 'html'
            }).done(function(response) {
                $('#modal').modal({backdrop: 'static', keyboard: false})
                $('.modal-content').html(response)
            });
        }
    </script>
@endpush
