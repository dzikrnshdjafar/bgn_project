<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    protected $fillable = [
        'sekolah_id',
        'sppg_id',
        'jadwal_menu_id',
        'tanggal_distribusi',
        'status_pengantaran',
        'keterangan',
        'tanggal_konfirmasi',
    ];

    protected $casts = [
        'tanggal_distribusi' => 'date',
        'tanggal_konfirmasi' => 'datetime',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }

    public function jadwalMenu()
    {
        return $this->belongsTo(JadwalMenu::class);
    }
}
