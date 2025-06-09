<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'keterangan',
        'status',
        'biaya',
    ];

    // Relasi ke Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk status dalam bentuk teks
    public function getStatusTextAttribute()
    {
        return match ((int) $this->status) {
            0 => 'Pending',
            1 => 'Sukses',
            2 => 'Gagal',
            default => 'Unknown',
        };
    }
}
