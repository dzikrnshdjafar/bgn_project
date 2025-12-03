<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    protected $fillable = [
        'sekolah_id',
        'tanggal',
        'total_siswa',
        'siswa_hadir',
        'siswa_tidak_hadir',
        'keterangan',
        'status_pengantaran',
        'makanan_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }
}
