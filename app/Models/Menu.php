<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'kategori_menu_id',
        'nama_menu',
        'deskripsi',
    ];

    public function kategoriMenu()
    {
        return $this->belongsTo(KategoriMenu::class);
    }
}
