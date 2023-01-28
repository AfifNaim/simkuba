@extends('layouts.app')
@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Profil UMKM</h1>
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
                                    Halaman ini adalah Profil UMKM yang berisi informasi UMKM yang dikelola oleh user
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Nama UMKM</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="inlineFormInputGroup" name="name" readonly value="{{ $company->name }}">
                                        </div>
                                        <span class="text-danger" id="name-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Alamat UMKM</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="inlineFormInputGroup" name="address" readonly value="{{ $company->address }}">
                                        </div>
                                        <span class="text-danger" id="address-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Logo</label><br>
                                        <img src="{{ asset('images/company/'.$company->logo) }}" width="200px" alt="image">
                                    </div>
                                </div>
                            </div>
                            @role('Manager')
                            <button class="btn btn-primary btn-lg text-white" onclick="showEditForm({{ $company->id }})">Edit</button>
                            @endrole
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.modal')
@endsection

@push('javascript')
    <script>
        function showEditForm(id) {
            console.log(id)
            $.ajax({
                type: "GET",
                url: "{{ url('companies') }}/"+id+"/edit",
                dataType: 'html'
            }).done(function(response) {
                $('#modal').modal({backdrop: 'static', keyboard: false})
                $('.modal-content').html(response)
            });
        }

    </script>
@endpush
