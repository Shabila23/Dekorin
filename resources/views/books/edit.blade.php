@extends('template')
@section('title', 'Edit Buku')

@section('content')
<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $book->pengarang) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->category }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar (opsional)</label>
            @if($book->image)
                <div>
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Gambar Buku" width="100">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $book->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (opsional)</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="{{ old('rating', $book->rating) }}">
        </div>

        <div class="mb-3">
            <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" name="tgl_terbit" class="form-control" value="{{ old('tgl_terbit', $book->tgl_terbit->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">File Buku (PDF)</label>
            @if($book->file)
                <div>
                    <a href="{{ asset('storage/' . $book->file) }}" target="_blank">Download File</a>
                </div>
            @endif
            <input type="file" name="file" class="form-control" accept=".pdf">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
