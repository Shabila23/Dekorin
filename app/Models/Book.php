<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'description',
        'image',
        'price',
        'rating',
        'pengarang',
        'tgl_terbit',
        'file'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}