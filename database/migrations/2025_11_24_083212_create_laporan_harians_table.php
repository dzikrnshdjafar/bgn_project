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
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('total_siswa')->default(0);
            $table->integer('siswa_hadir')->default(0);
            $table->integer('siswa_tidak_hadir')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Unique constraint untuk sekolah dan tanggal (satu laporan per hari per sekolah)
            $table->unique(['sekolah_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harians');
    }
};
