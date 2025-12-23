<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dapur_sehat_id',
        'nama_sekolah',
        'alamat_sekolah',
        'jumlah_siswa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dapurSehat()
    {
        return $this->belongsTo(DapurSehat::class);
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function laporanHarians()
    {
        return $this->hasMany(LaporanHarian::class);
    }
}
