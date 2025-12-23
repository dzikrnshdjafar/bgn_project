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
        // Drop existing jadwal_menu_likes table
        Schema::dropIfExists('jadwal_menu_likes');

        // Create new jadwal_menu_likes with counter system
        Schema::create('jadwal_menu_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_menu_id')->constrained('jadwal_menus')->onDelete('cascade');
            $table->date('tanggal');
            $table->unsignedInteger('like_count')->default(0);
            $table->timestamps();

            // Unique constraint untuk prevent duplicate per tanggal
            $table->unique(['jadwal_menu_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_menu_likes');

        // Restore old structure
        Schema::create('jadwal_menu_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jadwal_menu_id')->constrained('jadwal_menus')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }
};
