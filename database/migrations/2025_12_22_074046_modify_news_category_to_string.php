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
        DB::statement("ALTER TABLE news MODIFY category VARCHAR(100) DEFAULT 'berita'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to enum (note: this will fail if there are values not in the enum)
        DB::statement("ALTER TABLE news MODIFY category ENUM('berita', 'pengumuman', 'artikel', 'kegiatan') DEFAULT 'berita'");
    }
};
