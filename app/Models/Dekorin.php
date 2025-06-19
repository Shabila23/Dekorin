<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dekorin extends Model
{
    use HasFactory;

    protected $fillable = [
        'tema',
        'category_id',
        'image',
        'description',
        'price',
        'rating',
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
