<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMakanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function makanans()
    {
        return $this->hasMany(Makanan::class);
    }
}
