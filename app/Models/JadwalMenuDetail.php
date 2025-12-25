<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalMenuDetail extends Model
{
    protected $table = 'jadwal_menu_detail';

    protected $fillable = [
        'jadwal_menu_id',
        'menu_id',
        'kategori_menu_id',
    ];

    public function jadwalMenu(): BelongsTo
    {
        return $this->belongsTo(JadwalMenu::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function kategoriMenu(): BelongsTo
    {
        return $this->belongsTo(KategoriMenu::class);
    }
}
