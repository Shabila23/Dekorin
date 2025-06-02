<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'pengarang',
        'category_id',
        'image',
        'price',
        'rating',
        'tgl_terbit',
        'file',
    ];

    protected $casts = [
        'tgl_terbit' => 'date', // atau 'datetime' jika ingin menyertakan waktu
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
