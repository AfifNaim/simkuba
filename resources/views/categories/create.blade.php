<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $tittle }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="category-form" action="{{ route('categories.store') }}" method="POST">
    <div class="modal-body">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama Kategori</strong>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama Kategori">
                    <!-- error message untuk title -->
                    <span class="text-danger" id="name-error"></span>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Jenis Kategori</strong>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="type" value="K" class="selectgroup-input" {{ old('type') == 'K' ? "checked" : "" }} >
                            <span class="selectgroup-button">PEMASUKAN</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="type" value="D" class="selectgroup-input" {{ old('type') == 'D' ? "checked" : "" }} >
                            <span class="selectgroup-button">PENGELUARAN</span>
                        </label>
                    </div>
                    <!-- error message untuk title -->
                    <span class="text-danger" id="type-error"></span>
                    @error('type')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
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

    $("#category-form").on("submit", function(e) {
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
                window.location.href = "{{ url('categories?name=') }}"+response.name
            },
            error: function(response){
                console.log(response)
                $('#name-error').text(response.responseJSON.errors.name);
                $('#type-error').text(response.responseJSON.errors.type);
            }
        });
    })

</script>

