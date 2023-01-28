<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $tittle }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('categories.update', ['category' => $category]) }}" method="POST">
    <div class="modal-body">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama Kategori</strong>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $category->name }}" placeholder="Nama Kategori">
                    <!-- error message untuk title -->
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
                            <input type="radio" name="type" value="K" class="selectgroup-input" {{ old('type') == 'K' || $category->type == 'K' ? "checked" : "" }} >
                            <span class="selectgroup-button">PEMASUKAN</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="type" value="D" class="selectgroup-input" {{ old('type') == 'D' || $category->type == 'D' ? "checked" : "" }} >
                            <span class="selectgroup-button">PENGELUARAN</span>
                        </label>
                    </div>
                    <!-- error message untuk title -->
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
