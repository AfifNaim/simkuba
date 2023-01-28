@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profil UMKM</h1>
        </div>

        <div class="section-body">
            @include('partials.message')
            <div class="card p-4">
                <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Nama UMKM</strong>
                                <input type="text" name="name" class="form-control" placeholder="Nama UMKM">
                                @if ($errors->has('name'))
                                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Alamat</strong>
                                <textarea type="text" name="address" class="form-control" style="height: 100px;"></textarea>
                                @if ($errors->has('address'))
                                    <span class="text-danger text-left">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Logo</strong>
                                <input type="file" name="logo" class="form-control">
                                @if ($errors->has('logo'))
                                    <span class="text-danger text-left">{{ $errors->first('logo') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 text-left">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
 @endsection
