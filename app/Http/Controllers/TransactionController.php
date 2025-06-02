<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi (Read)
    public function index()
    {
        $transactions = Transaction::with(['book', 'user'])->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    // Menampilkan form edit transaksi (Update)
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $books = Book::all();   // Untuk dropdown buku
        $users = User::all();   // Untuk dropdown user
        return view('transactions.edit', compact('transaction', 'books', 'users'));
    }

    // Memproses update transaksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',  // Validasi user_id
            'keterangan' => 'required|string',
            'status' => 'required|in:0,1,2',
            'biaya' => 'required|numeric|min:0',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Menghapus transaksi (Delete)
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
