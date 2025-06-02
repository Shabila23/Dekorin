<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionApprovalController extends Controller
{
    /**
     * Tampilkan daftar transaksi dengan status pending
     */
    public function index()
    {
        $transactions = Transaction::with('user')
            ->where('status', '0') // status pending
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.approval', compact('transactions'));
    }

    /**
     * Approve transaksi: ubah status jadi sukses dan update saldo user
     */
    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->status != '0') {
                abort(400, 'Transaksi sudah diproses');
            }

            // Update status transaksi menjadi sukses
            $transaction->status = '1';
            $transaction->save();

            // Update saldo user
            $user = $transaction->user;
            $user->saldo += $transaction->biaya;
            $user->save();
        });

        return redirect()->route('transactions.approval')->with('success', 'Transaksi berhasil disetujui dan saldo user diperbarui.');
    }

    /**
     * Tolak transaksi: ubah status jadi gagal, saldo user tidak berubah
     */
    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status != '0') {
            abort(400, 'Transaksi sudah diproses');
        }

        $transaction->status = '2'; // gagal
        $transaction->save();

        return redirect()->route('transactions.approval')->with('success', 'Transaksi berhasil ditolak.');
    }
}
