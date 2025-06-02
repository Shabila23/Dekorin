@extends('template')
@section('title', 'Need Approval Transactions')

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

    @if($transactions->isEmpty())
        <p>Tidak ada transaksi pending saat ini.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Keterangan</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $transaction->user->name ?? 'User tidak ditemukan' }}</td>
                    <td>{{ $transaction->keterangan }}</td>
                    <td><span class="coin">$</span> {{ number_format($transaction->biaya, 0, ',', '.') }}</td>
                    <td>
                        @if($transaction->status == '0')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($transaction->status == '1')
                            <span class="badge bg-success">Sukses</span>
                        @else
                            <span class="badge bg-danger">Gagal</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('transactions.approve', $transaction->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui transaksi ini?')">Approve</button>
                        </form>

                        <form action="{{ route('transactions.reject', $transaction->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak transaksi ini?')">Tolak</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
