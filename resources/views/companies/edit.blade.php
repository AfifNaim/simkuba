<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit UMKM</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="cashbook-form" action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Nama</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="inlineFormInputGroup" name="name" value="{{ $company->name }}" placeholder="Nama">
                    </div>
                    <span class="text-danger" id="name-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Alamat</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="inlineFormInputGroup" name="address" value="{{ $company->address }}" placeholder="Alamat">
                    </div>
                    <span class="text-danger" id="address-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Logo</label><br>
                    <img src="{{ asset('images/company/'.$company->logo) }}" width="100px" alt="image">
                    <input type="file" class="form-control" name="logo">
                    <span class="text-danger" id="logo-error"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script type="text/javascript">

    $("#company-form").on("submit", function(e) {
        e.preventDefault();

        let action = $(this).attr("action"); //get submit action from form
        let method = $(this).attr("method"); // get submit method
        let form_data = new FormData($(this)[0]); // convert form into form data
        let form = $(this);

        $.ajax({
            url: action,
            dataType: 'json', // what to expect back from the server
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: method,

            success: function(response){
                window.location.href = "{{ url('company?id=') }}"+response.id
            },
            error: function(response){
                console.log(response)
                $('#name-error').text(response.responseJSON.errors.name);
                $('#address-error').text(response.responseJSON.errors.address);
                $('#logo-error').text(response.responseJSON.errors.logo);
            }
        });
    })

</script>
