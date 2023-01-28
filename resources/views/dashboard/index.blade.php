@extends('layouts.app')

@section('title', 'Dashboard')

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
            <h1>Dashboard</h1>
        </div>
        <div class="section-body">
          <div class="row">
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pemasukan hari ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-success">{{ 'Rp. ' . number_format($sumIncomebyDay) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pemasukan Minggu ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-success">{{ 'Rp. ' . number_format($sumIncomebyWeek) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pemasukan Bulan ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-success">{{ 'Rp. ' . number_format($sumIncomebyMonth) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pemasukan Tahun ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-success">{{ 'Rp. ' . number_format($sumIncomebyYear) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-8">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pemasukan Keseluruhan</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-success">{{ 'Rp. ' . number_format($sumIncomeallTime) }}</a>
                  </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pengeluaran hari ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-danger">{{ 'Rp. ' . number_format($sumIncomebyDay) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pengeluaran hari ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-danger">{{ 'Rp. ' . number_format($sumIncomebyWeek) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pengeluaran hari ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-danger">{{ 'Rp. ' . number_format($sumIncomebyMonth) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pengeluaran hari ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-danger">{{ 'Rp. ' . number_format($sumIncomebyYear) }}</a>
                  </div>
                </div>
            </div>
            <div class="col-sm-8">
              <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title">Pengeluaran hari ini</h3>
                    <p class="card-text">{{ date('D-M-Y') }}</p>
                    <a href="#" class="btn btn-danger">{{ 'Rp. ' . number_format($sumIncomeallTime) }}</a>
                  </div>
                </div>
            </div>
          </div>         
        </div>
    </section>

@endsection