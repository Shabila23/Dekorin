@extends('template')
@section('title', 'Data User')

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

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah User Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Saldo</th>
                <th>Created at</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="coin">$</span> {{ number_format($user->saldo, 0, ',', '.') }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    {{-- <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">Detail</a> --}}
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Tidak ada data user.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
