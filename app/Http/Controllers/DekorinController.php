<?php

namespace App\Http\Controllers;

use App\Models\Dekorin;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DekorinController extends Controller
{
    public function index()
    {
        $dekorins = Dekorin::with('category')->get();
        return view('dekorins.index', compact('dekorins'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dekorins.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tema' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|max:5',
            'tgl_terbit' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file' => 'nullable|file|mimes:pdf,docx,zip|max:5120',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('dekorins/images', 'public');
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('dekorins/files', 'public');
        }

        Dekorin::create($data);

        return redirect()->route('dekorins.index')->with('success', 'Dekorin berhasil ditambahkan.');
    }

    public function show(Dekorin $dekorin)
    {
        return view('dekorins.show', compact('dekorin'));
    }

    public function edit(Dekorin $dekorin)
    {
        $categories = Category::all();
        return view('dekorins.edit', compact('dekorin', 'categories'));
    }

    public function update(Request $request, Dekorin $dekorin)
    {
        $request->validate([
            'tema' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|max:5',
            'tgl_terbit' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file' => 'nullable|file|mimes:pdf,docx,zip|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus file lama (optional)
            if ($dekorin->image) {
                Storage::disk('public')->delete($dekorin->image);
            }
            $data['image'] = $request->file('image')->store('dekorins/images', 'public');
        }

        if ($request->hasFile('file')) {
            if ($dekorin->file) {
                Storage::disk('public')->delete($dekorin->file);
            }
            $data['file'] = $request->file('file')->store('dekorins/files', 'public');
        }

        $dekorin->update($data);

        return redirect()->route('dekorins.index')->with('success', 'Dekorin berhasil diperbarui.');
    }

    public function destroy(Dekorin $dekorin)
    {
        if ($dekorin->image) {
            Storage::disk('public')->delete($dekorin->image);
        }

        if ($dekorin->file) {
            Storage::disk('public')->delete($dekorin->file);
        }

        $dekorin->delete();

        return redirect()->route('dekorins.index')->with('success', 'Dekorin berhasil dihapus.');
    }
}
