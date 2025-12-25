<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_menu_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_menu_id')->constrained('jadwal_menus')->onDelete('cascade');
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->date('tanggal');
            $table->unsignedInteger('like_count')->default(0);
            $table->integer('jumlah_sisa')->default(0)->comment('Jumlah makanan yang tersisa (porsi)');
            $table->timestamps();

            // Unique constraint: satu row per menu per sekolah per tanggal
            $table->unique(['jadwal_menu_id', 'sekolah_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_menu_likes');
    }
};
