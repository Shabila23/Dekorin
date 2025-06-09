<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Tampilkan daftar buku
    public function index()
    {
        $books = Book::with('category')->paginate(10);
        return view('books.index', compact('books'));
    }

    // Tampilkan form tambah buku
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // Simpan data buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'tgl_terbit' => 'required|date',
            'file' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books/images', 'public');
        }

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('books/files', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Tampilkan form edit buku
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    // Update data buku
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'tgl_terbit' => 'required|date',
            'file' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Upload image jika ada dan hapus yang lama
        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books/images', 'public');
        }

        // Upload file jika ada dan hapus yang lama
        if ($request->hasFile('file')) {
            if ($book->file) {
                Storage::disk('public')->delete($book->file);
            }
            $validated['file'] = $request->file('file')->store('books/files', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    // Hapus buku
    public function destroy(Book $book)
    {
        // Hapus file image dan file jika ada
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        if ($book->file) {
            Storage::disk('public')->delete($book->file);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
