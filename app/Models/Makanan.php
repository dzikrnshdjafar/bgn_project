<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_makanan',
        'kategori_makanan_id',
        'deskripsi',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'makanan_kesukaan_id');
    }

    public function kategoriMakanan()
    {
        return $this->belongsTo(KategoriMakanan::class);
    }

    public function laporanHarians()
    {
        return $this->hasMany(LaporanHarian::class);
    }
}
