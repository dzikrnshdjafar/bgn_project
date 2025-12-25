<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JadwalMenu extends Model
{
    protected $fillable = [
        'sppg_id',
        'hari',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function sppg(): BelongsTo
    {
        return $this->belongsTo(Sppg::class);
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'jadwal_menu_detail', 'jadwal_menu_id', 'menu_id')
            ->withPivot('kategori_menu_id')
            ->withTimestamps();
    }

    public function details()
    {
        return $this->hasMany(JadwalMenuDetail::class);
    }
}
