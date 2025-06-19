@extends('template')

@section('title', 'Edit Dekorin')

@section('content')
    <h2>Edit Dekorin</h2>

    <form action="{{ route('dekorins.update', $dekorin->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tema" class="form-label">Tema</label>
            <input type="text" name="tema" value="{{ $dekorin->tema }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $dekorin->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control">
            @if ($dekorin->image)
                <img src="{{ asset('storage/' . $dekorin->image) }}" alt="Image" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control">{{ $dekorin->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" value="{{ $dekorin->price }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" step="0.1" max="5" name="rating" value="{{ $dekorin->rating }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">File Tambahan</label>
            <input type="file" name="file" class="form-control">
            @if ($dekorin->file)
                <a href="{{ asset('storage/' . $dekorin->file) }}" target="_blank">Lihat File</a>
            @endif
        </div>

        <div class="mb-3">
            <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" name="tgl_terbit" value="{{ $dekorin->tgl_terbit?->format('Y-m-d') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('dekorins.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
