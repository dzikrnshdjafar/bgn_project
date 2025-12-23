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
        Schema::table('jadwal_menu_likes', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('jadwal_menu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_menu_likes', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
