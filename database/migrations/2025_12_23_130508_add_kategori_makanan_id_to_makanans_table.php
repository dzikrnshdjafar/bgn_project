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
        Schema::table('makanans', function (Blueprint $table) {
            $table->foreignId('kategori_makanan_id')->nullable()->after('nama_makanan')->constrained('kategori_makanans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('makanans', function (Blueprint $table) {
            $table->dropForeign(['kategori_makanan_id']);
            $table->dropColumn('kategori_makanan_id');
        });
    }
};
