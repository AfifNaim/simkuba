@extends('layouts.app')

@section('tiitle', 'Pembukuan')

@section('content')

<section class="section">
        <div class="section-header">
            <h1>Laporan</h1>
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
                                        Halaman ini adalah Halaman Laporan yang berfungsi untuk mencetak laporan keuangan UMKM baik harian, bulanan, tahunan, dan filter waktu yang bisa di custom sesuai kebutuhan.
                                </div>
                            </div>
                </div>
        </div>

        <div class="card-body" align="center">
        <a target="_BLANK" href="{{ route('report.report_daily') }}" class="btn btn-success btn-md mb-4">Laporan Harian</a>
        <a target="_BLANK" href="{{ route('report.report_monthly') }}" class="btn btn-success btn-md mb-4">Laporan Bulanan</a>
        <a target="_BLANK" href="{{ route('report.report_annual') }}" class="btn btn-success btn-md mb-4">Laporan Tahunan</a>
        </div>
        <div class="section-body">
            <div class="card-body">
              <form method="GET" action="{{ route('report.index') }}">
                @csrf
                <div class="row">
                  <div class="col-lg-offset-2 col-lg-3">
                    <div class="form-group">
                      <label>Mulai Tanggal</label>

                      <input class="form-control datepicker2" placeholder="Dari Tanggal" type="date" required="required" name="from" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>Sampai Tanggal</label>
                      <input class="form-control datepicker2" placeholder="Sampai Tanggal" type="date" required="required" name="to" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label>Kategori</label>
                      <select class="form-control" name="categories">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $categories)
                        <option <?php if(isset($_GET['categories'])){ if($_GET['categories'] == $categories->id){echo "selected='selected'";} } ?> value="{{ $categories->id }}">{{ $categories->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" value="Tampilkan" style="margin-top: 25px">
                    </div>
                  </div>
                </div>
              </form>
              <br>
            </div>
              @if(isset($_GET['categories']))

            <div class="card">

              <div class="card-header pt-4">
                <h3 class="card-title">Data Laporan Keuangan</h3>
              </div>
              <div class="card-body">

                <table style="width: 50%">
                  <tr>
                    <th width="25%">DARI TANGGAL</th>
                    <th width="5%" class="text-center">:</th>
                    <td>{{ date('d-m-Y',strtotime($_GET['from'])) }}</td>
                  </tr>
                  <tr>
                    <th width="25%">SAMPAI TANGGAL</th>
                    <th width="5%" class="text-center">:</th>
                    <td>{{ date('d-m-Y',strtotime($_GET['to'])) }}</td>
                  </tr>
                  <tr>
                    <th width="25%">KATEGORI</th>
                    <th width="5%" class="text-center">:</th>
                    <td>
                      @php
                      $category_id = $_GET['categories'];
                      @endphp

                      @if($category_id == "")
                        @php
                        $categoryAll = "SEMUA KATEGORI";
                        @endphp
                      @else
                        @php
                          $getCategory = DB::table('categories')->where('id',$category_id)->first();
                          $categoryAll = $getCategory->name
                        @endphp
                      @endif

                      {{$categoryAll}}
                    </td>
                  </tr>
                </table>

                <br>
                <br>
                <a target="_BLANK" href="{{ route('report.report_excel',['categories' => $_GET['categories'], 'from' => $_GET['from'], 'to' => $_GET['to']]) }}" class="btn btn-outline-secondary"><i class="fa fa-file-excel-o "></i> &nbsp; CETAK EXCEL</a>
                <a target="_BLANK" href="{{ route('report.report_pdf',['categories' => $_GET['categories'], 'from' => $_GET['from'], 'to' => $_GET['to']]) }}" class="btn btn-outline-secondary"><i class="fa fa-print "></i> &nbsp; CETAK PDF</a>
                <br>
                <br>
                <br>

                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th rowspan="2" class="text-center" width="1%">NO</th>
                        <th rowspan="2" class="text-center" width="9%">TANGGAL</th>
                        <th rowspan="2" class="text-center">KATEGORI</th>
                        <th rowspan="2" class="text-center">KETERANGAN</th>
                        <th colspan="2" class="text-center">JENIS</th>
                      </tr>
                      <tr>
                        <th class="text-center">PEMASUKAN</th>
                        <th class="text-center">PENGELUARAN</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $number = 1;
                      $sumIncome = 0;
                      $sumExpense = 0;
                      @endphp
                      @foreach($cashbooks as $cashbook)
                      <tr>
                        <td class="text-center">{{ $number++ }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($cashbook->date )) }}</td>
                        <td>{{ $cashbook->category->name }}</td>
                        <td>{{ $cashbook->description }}</td>
                        <td class="text-center">
                          @if($cashbook->type == "K")
                          {{ "Rp.".number_format($cashbook->amount).",-" }}
                          @php $sumIncome += $cashbook->amount; @endphp
                          @else
                          {{ "-" }}
                          @endif
                        </td>
                        <td class="text-center">
                          @if($cashbook->type == "D")
                          {{ "Rp.".number_format($cashbook->amount).",-" }}
                          @php $sumExpense += $cashbook->amount; @endphp
                          @else
                          {{ "-" }}
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot class="bg-info text-white font-weight-bold">
                      <tr>
                        <td colspan="4" class="text-bold text-right">TOTAL</td>
                        <td class="text-center">{{ "Rp.".number_format($sumIncome).",-" }}</td>
                        <td class="text-center">{{ "Rp.".number_format($sumExpense).",-" }}</td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              </div>

            </div>
          @endif
        </div>
    </section>

@endsection
