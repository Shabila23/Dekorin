@extends('template')
@section('title', 'Data Buku')

@push('css')
    <style>
        .coin {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background-color: #ffeb3b;
            /* Kuning cerah */
            border: 2px solid #fbc02d;
            /* Border kuning gelap */
            border-radius: 50%;
            /* Membuat lingkaran */
            font-weight: bold;
            font-size: 12px;
            color: #795548;
            /* Warna coklat tua untuk kontras */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            /* Sedikit bayangan agar terlihat mengambang */
            user-select: none;
            /* Agar teks tidak bisa diseleksi */
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th style="width: 250px;">Judul</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Rating</th>
                    <th>Tanggal Terbit</th>
                    <th>Gambar</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->pengarang }}</td>
                        <td>{{ $book->category->category ?? '-' }}</td>
                        <td><span class="coin">$</span> {{ number_format($book->price, 0, '.', ',') }}</td>
                        <td>{{ $book->rating ?? '-' }}</td>
                        <td><small>{{ $book->tgl_terbit->format('d-m-Y') }}</small></td>
                        <td>
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Gambar Buku" width="50">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($book->file)
                                <a href="{{ asset('storage/' . $book->file) }}" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $books->links() }}
    </div>
@endsection
