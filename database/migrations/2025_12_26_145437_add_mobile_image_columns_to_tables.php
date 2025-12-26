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
        // Add mobile image column to news table
        Schema::table('news', function (Blueprint $table) {
            $table->string('featured_image_mobile')->nullable()->after('featured_image');
        });

        // Add mobile image column to galleries table
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('file_path_mobile')->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('featured_image_mobile');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('file_path_mobile');
        });
    }
};
