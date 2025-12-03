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
        Schema::table('laporan_harians', function (Blueprint $table) {
            $table->foreignId('makanan_id')->nullable()->after('status_pengantaran')->constrained('makanans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_harians', function (Blueprint $table) {
            $table->dropForeign(['makanan_id']);
            $table->dropColumn('makanan_id');
        });
    }
};
