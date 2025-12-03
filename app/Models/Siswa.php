<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'sekolah_id',
        'nama_siswa',
        'makanan_kesukaan_id',
        'kehadiran',
    ];

    protected $casts = [
        'kehadiran' => 'boolean',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function makananKesukaan()
    {
        return $this->belongsTo(Makanan::class, 'makanan_kesukaan_id');
    }
}
