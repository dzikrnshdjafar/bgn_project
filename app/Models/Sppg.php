<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppg extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_dapur',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sekolahs()
    {
        return $this->hasMany(Sekolah::class);
    }

    public function distribusis()
    {
        return $this->hasMany(Distribusi::class);
    }
}
