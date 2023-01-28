<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
    <div class="modal-body">
        <p>Tanggal</p>
        <h5>{{ $cashBook->date }}</h5>
        <p>Kategori</p>
        <h5>{{ $cashBook->category->name }}</h5>
        <p>Nominal</p>
        <h5 class="{{ $cashBook->type == "K" ? 'text-success' : 'text-danger' }}">Rp{{ number_format($cashBook->amount, 0, ',', '.') }}</h5>
        <p>Qty</p>
        <h5>{{ $cashBook->qty }}</h5>
        <p>Total</p>
        <h5 class="{{ $cashBook->type == "K" ? 'text-success' : 'text-danger' }}">Rp{{ number_format($cashBook->summary, 0, ',', '.') }}</h5>
        @if($cashBook->image)
            <p>Foto</p>
            <image src="{{ asset('images/cashbook/'.$cashBook->image) }}" width="100%" />
        @endif
        <br>
        <p>Catatan</p>
        <h5>{{ $cashBook->description }}</h5>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
