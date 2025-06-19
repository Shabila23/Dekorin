@extends('template')

@section('title', 'Tambah Dekorin')

@section('content')
    <h2>Tambah Dekorin</h2>

    <form action="{{ route('dekorins.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="tema" class="form-label">Tema</label>
            <input type="text" name="tema" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" step="0.1" max="5" name="rating" class="form-control">
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">File Tambahan</label>
            <input type="file" name="file" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" name="tgl_terbit" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('dekorins.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
