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
        // This pivot table is no longer needed since we changed to one-to-many relationship
        // The relationship is now: 1 SPPG has many Sekolahs, 1 Sekolah belongs to 1 SPPG
        // sppg_id and zona are now stored directly in sekolahs table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah_sppg');
    }
};
