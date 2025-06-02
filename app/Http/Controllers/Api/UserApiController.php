<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    /**
     * Registrasi user baru
     */
    public function register_user(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'no_hp' => 'nullable|string|max:15',
        ]);

        try {
            // Buat user baru dengan token random
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'no_hp' => $request->no_hp,
            ]);

            // Respon sukses
            return response()->json([
                'message' => 'User berhasil dibuat',
                'token_type' => 'Bearer',
                'id' => $user->id,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 200);
        } catch (\Exception $e) {
            // Respon error
            return response()->json([
                'message' => 'ERROR',
                'errors' => 'Gagal membuat user: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Login user
     */
    public function login_user(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 400);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password salah'], 400);
        }

        // Jika login berhasil, kembalikan token user
        return response()->json([
            'message' => 'Login berhasil',
            'id' => $user->id,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 200);
        }

    public function profile(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Jika login berhasil, kembalikan token user
        return response()->json([
            'message' => 'Profile berhasil diambil',
            'data' => $request->user(),
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        // Menghapus token yang sedang digunakan oleh user (Laravel Sanctum)
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil, token telah dihapus.'
        ]);
    }

    public function topUpSaldo(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'biaya' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validasi gagal',
                'message' => $validator->errors()
            ], 400);
        }

        try {
            // Buat transaksi baru dengan status 0 (pending), keterangan "Top-Up", book_id null
            $transaction = Transaction::create([
                'book_id' => null,
                'user_id' => $request->input('user_id'),
                'keterangan' => 'Top-Up',
                'status' => 0,
                'biaya' => $request->input('biaya'),
            ]);

            return response()->json([
                'success'=> true,
                'message' => 'Permintaan top-up berhasil dibuat',
                'transaction' => $transaction
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memproses permintaan top-up'.$e->getMessage()
            ], 500);
        }
    }

    public function getbooks(): JsonResponse
    {
        // Mengambil data buku beserta relasi category (hanya field 'category')
        $books = Book::with('category:id,category')
            ->select([
                'id',
                'title',
                'category_id',
                'description', // Jika ada di tabel, jika tidak hapus baris ini
                'image',
                'price',
                'rating',
                'pengarang',
                'tgl_terbit',
                'file' // Jika ingin ditampilkan juga
            ])
            ->get();

        // Format response agar category menjadi string langsung dan image/file menjadi URL lengkap
        $books->transform(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'category' => $book->category ? $book->category->category : null,
                'description' => $book->description ?? null,
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'price' => $book->price,
                'rating' => $book->rating,
                'pengarang' => $book->pengarang,
                'tgl_terbit' => $book->tgl_terbit ? $book->tgl_terbit->format('d-m-Y') : null,
                'file' => $book->file ? asset('storage/' . $book->file) : null,
            ];
        });

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $books
        // ]);
        return response()->json($books);
    }

    public function getBookById(int $id): JsonResponse
    {
        // Mengambil data buku dengan relasi category
        $book = Book::with('category:id,category')->find($id);

        // Jika buku tidak ditemukan
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        // Format response dengan URL lengkap untuk image dan file
        $responseData = [
            'id' => $book->id,
            'title' => $book->title,
            'category' => $book->category ? $book->category->category : null,
            'description' => $book->description ?? null,
            'image' => $book->image ? asset('storage/' . $book->image) : null,
            'price' => $book->price,
            'rating' => $book->rating,
            'pengarang' => $book->pengarang,
            'tgl_terbit' => $book->tgl_terbit ? $book->tgl_terbit->format('d-m-Y') : null,
            'file' => $book->file ? asset('storage/' . $book->file) : null,
        ];

        return response()->json($responseData);
    }

    public function getBooksByCategory(string $category_name): JsonResponse
    {
        // Mengambil buku dengan relasi category yang memiliki nama kategori sesuai parameter
        $books = Book::with('category:id,category')
            ->whereHas('category', function ($query) use ($category_name) {
                $query->where('category', $category_name);
            })
            ->get();

        // Jika tidak ada buku ditemukan
        if ($books->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada buku ditemukan untuk kategori: ' . $category_name
            ], 404);
        }

        // Format data buku dengan URL lengkap untuk image dan file
        $responseData = $books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'category' => $book->category ? $book->category->category : null,
                'description' => $book->description ?? null,
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'price' => $book->price,
                'rating' => $book->rating,
                'pengarang' => $book->pengarang,
                'tgl_terbit' => $book->tgl_terbit ? $book->tgl_terbit->format('d-m-Y') : null,
                'file' => $book->file ? asset('storage/' . $book->file) : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $responseData
        ]);
    }

    public function getPurchasedBooksByUser(int $user_id): JsonResponse
    {
        // Mengambil book_id dari transaksi yang sudah dibeli user (book_id tidak null)
        $purchasedBookIds = DB::table('transactions')
            ->where('user_id', $user_id)
            ->whereNotNull('book_id')
            ->pluck('book_id')
            ->unique();

        if ($purchasedBookIds->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User dengan ID ' . $user_id . ' belum membeli buku apapun.'
            ], 404);
        }

        // Mengambil data buku berdasarkan book_id yang sudah dibeli user
        $books = Book::with('category:id,category')
            ->whereIn('id', $purchasedBookIds)
            ->get();

        // Format data buku dengan URL lengkap untuk image dan file
        $responseData = $books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'category' => $book->category ? $book->category->category : null,
                'description' => $book->description ?? null,
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'price' => $book->price,
                'rating' => $book->rating,
                'pengarang' => $book->pengarang,
                'tgl_terbit' => $book->tgl_terbit ? $book->tgl_terbit->format('d-m-Y') : null,
                'file' => $book->file ? asset('storage/' . $book->file) : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $responseData
        ]);
    }

    public function getTransactionsByUser(int $user_id): JsonResponse
    {
        // Mengambil semua transaksi yang terkait dengan user_id
        $transactions = DB::table('transactions')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User dengan ID ' . $user_id . ' belum memiliki transaksi.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ]);
    }


    public function getCategories(): JsonResponse
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function purchaseBook(Request $request): JsonResponse
    {
        // Validasi input request
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'keterangan' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'status' => 'required|integer',
        ]);

        // Gunakan transaksi database agar proses atomik
        DB::beginTransaction();

        try {
            // Ambil user berdasarkan user_id
            $user = User::findOrFail($validated['user_id']);

            // Cek apakah saldo user cukup
            if ($user->saldo < $validated['biaya']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Saldo tidak cukup untuk melakukan pembelian.'
                ], 400);
            }

            // Buat data transaksi baru
            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'book_id' => $validated['book_id'],
                'keterangan' => $validated['keterangan'],
                'biaya' => $validated['biaya'],
                'status' => 1,
            ]);

            // Kurangi saldo user sesuai biaya pembelian
            $user->saldo -= $validated['biaya'];
            $user->save();

            // Commit transaksi database
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pembelian buku berhasil disimpan dan saldo user telah dikurangi.',
                'data' => $transaction
            ], 201);

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan pembelian buku: ' . $e->getMessage(),
            ], 500);
        }
    }


}
