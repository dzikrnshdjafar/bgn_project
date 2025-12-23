<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMenu extends Model
{
    protected $fillable = [
        'dapur_sehat_id',
        'hari',
        'keterangan',
    ];

    public function dapurSehat()
    {
        return $this->belongsTo(DapurSehat::class);
    }

    public function makanans()
    {
        return $this->belongsToMany(Makanan::class, 'jadwal_menu_makanan');
    }

    // Note: Likes now use counter system in jadwal_menu_likes table
    // Access via DB::table('jadwal_menu_likes') directly
}
