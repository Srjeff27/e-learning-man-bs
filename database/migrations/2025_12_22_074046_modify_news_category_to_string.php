<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change enum to string to allow any category value
        Schema::table('news', function (Blueprint $table) {
            $table->string('category', 100)->default('berita')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to enum (note: this will fail if there are values not in the enum)
        Schema::table('news', function (Blueprint $table) {
            // In Laravel, there isn't a direct way to 'change' to enum easily across all drivers without dbal issues sometimes.
            // But for down(), strictly speaking we can try:
            $table->enum('category', ['berita', 'pengumuman', 'artikel', 'kegiatan'])->default('berita')->change();
        });
    }
};
