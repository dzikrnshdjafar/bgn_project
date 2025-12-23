<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DapurSehat extends Model
{
    use HasFactory;

    protected $table = 'dapur_sehats';

    protected $fillable = [
        'user_id',
        'nama_dapur',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function makanans()
    {
        return $this->hasMany(Makanan::class);
    }

    public function sekolahs()
    {
        return $this->hasMany(Sekolah::class);
    }
}
