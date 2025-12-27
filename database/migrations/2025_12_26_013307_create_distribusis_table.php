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
        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->foreignId('sppg_id')->constrained('sppgs')->onDelete('cascade');
            $table->foreignId('jadwal_menu_id')->constrained('jadwal_menus')->onDelete('cascade');
            $table->date('tanggal_distribusi');
            $table->enum('status_pengantaran', ['belum_diterima', 'sudah_diterima'])->default('belum_diterima');
            $table->text('keterangan')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->timestamp('tanggal_konfirmasi')->nullable();
            $table->timestamps();

            // Unique constraint untuk mencegah duplikasi
            $table->unique(['sekolah_id', 'jadwal_menu_id', 'tanggal_distribusi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};
