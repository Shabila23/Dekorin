@extends('template')

@section('title', 'Dekorin')

@section('content')
    <h2>List Dekorin</h2>

    @if ($dekorins->isEmpty())
        <div class="alert alert-info">
            Belum ada data Dekorin.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tema</th>
                    <th>category</th>
                    <th>Harga</th>
                    <th>Rating</th>
                    <th>Tgl Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dekorins as $index => $dekorin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dekorin->tema }}</td>
                        <td>{{ $dekorin->category->category ?? '-' }}</td> {{-- gunakan nama kolom yg sesuai di tabel categories --}}
                        <td>Rp{{ number_format($dekorin->price, 0, ',', '.') }}</td>
                        <td>{{ $dekorin->rating }}/5</td>
                        <td>{{ $dekorin->tgl_terbit?->format('d-m-Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('dekorins.edit', $dekorin->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('dekorins.destroy', $dekorin->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('dekorins.create') }}" class="btn btn-primary mt-3">+ Tambah Dekorin</a>
@endsection
