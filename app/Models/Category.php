<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Ganti sesuai nama kolom sebenarnya di tabel categories
    protected $fillable = ['category']; 

    // Relasi ke model Book
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }

    // Relasi ke model Dekorin
    public function dekorins()
    {
        return $this->hasMany(Dekorin::class, 'category_id');
    }
}
