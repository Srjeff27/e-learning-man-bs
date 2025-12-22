<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('semester', 20)->default('ganjil')->after('category'); // ganjil or genap
            $table->string('academic_year', 20)->nullable()->after('semester'); // e.g., 2025/2026
            $table->string('event_type', 50)->nullable()->after('academic_year'); // kegiatan, ujian, libur, nasional, kemerdekaan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['semester', 'academic_year', 'event_type']);
        });
    }
};
