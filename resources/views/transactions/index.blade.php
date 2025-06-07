@extends('template')
@section('title', 'Data Transaksi')

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

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Buku</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Biaya</th>
                <th>Created at</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->user->name ?? '-' }}</td>
                <td>{{ $transaction->book->title ?? '-' }}</td>
                <td>{{ $transaction->keterangan }}</td>
                <td>
                    @php
                        $statusClass = match ($transaction->status) {
                            0 => 'badge bg-warning',
                            1 => 'badge bg-success',
                            2 => 'badge bg-danger',
                            default => 'badge bg-secondary',
                        };
                    @endphp
                    <span class="{{ $statusClass }}">{{ $transaction->status_text }}</span>
                </td>
                <td><span class="coin">$</span> {{ number_format($transaction->biaya, 0, ',', '.') }}</td>
                <td><small><i>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</i></small></td>
                <td>
                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-danger">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $transactions->links() }}
</div>
@endsection
