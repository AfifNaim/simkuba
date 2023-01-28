<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="cashbook-form" action="{{ route('cash-books.store') }}" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" name="date" value="{{ now()->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="category_id" id="select-category" >
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <!-- error message untuk title -->
                    <span class="text-danger" id="category_id-error"></span>
                    <div class="row ml-1">
                        <button type="button" class="btn btn-md btn-info mt-3" id="btn-add-category" onclick="showAddCategoryForm()"><i class="fa fa-plus"></i>&ensp;Kategori Baru</button>
                    </div>
                    <div id="add-category" class="mt-3 mb-2" style="display: none">
                        <div class="float-left" style="width: 70%;">
                            <input type="text" class="form-control" name="category_name" id="category-form" placeholder="Kategori"/>
                            <span class="text-danger" id="category-error"></span>
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-lg btn-primary m-0" id="btn-add-category" title="Simpan Kategori" onclick="saveCategory()"><i class="fa fa-save"></i></button>
                            <button type="button" class="btn btn-lg btn-danger m-0" id="btn-cancel-category" title="Batal" onclick="hideAddCategoryForm()"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Nominal</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp</div>
                        </div>
                        <input type="number" class="form-control" id="inlineFormInputGroup" name="amount" min="0" placeholder="Nominal">
                    </div>
                    <span class="text-danger" id="nominal-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Qty</label>
                    <input type="number" class="form-control" name="qty" min="1" value="1">
                    <span class="text-danger" id="qty-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" class="form-control" name="image">
                    <span class="text-danger" id="image-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea class="form-control" style="height: 70px;" name="description" ></textarea>
                    <span class="text-danger" id="desc-error"></span>
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

    function showAddCategoryForm() {
        $("#add-category").show()
        $("#btn-add-category").hide()
    }

    function hideAddCategoryForm() {
        $("#add-category").hide()
        $("#btn-add-category").show()
        $('#category-form').val('')
        $('#category-error').text('')
    }

    function saveCategory() {
        let category_name = $('#category-form').val();

        $.ajax({
            type: "POST",
            url: "{{ route('categories.store') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                name: category_name,
                type: "{{ $type }}"
            },
            dataType: 'json',
            success: function(response){
                $('#select-category').append('<option value="'+response.id+'" selected>'+response.name+'</option>')
                hideAddCategoryForm()
            },
            error: function(response){
                $('#category-error').text(response.responseJSON.errors.name);
            }
        });
    }

    $("#cashbook-form").on("submit", function(e) {
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
                window.location.href = "{{ url('cash-books?id=') }}"+response.id
            },
            error: function(response){
                console.log(response)
                $('#category_id-error').text(response.responseJSON.errors.category_id);
                $('#nominal-error').text(response.responseJSON.errors.amount);
                $('#image-error').text(response.responseJSON.errors.image);
                $('#qty-error').text(response.responseJSON.errors.qty);
                $('#desc-error').text(response.responseJSON.errors.description);
            }
        });
    })

</script>
