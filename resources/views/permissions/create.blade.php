@extends('layouts.app')

@section('title', 'Tambah Permission')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Permission Baru</h1>
        </div>

        <div class="section-body">
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}"
                           type="text"
                           class="form-control"
                           name="name"
                           placeholder="Name" required />

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Save permission</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>
    </section>
@endsection
