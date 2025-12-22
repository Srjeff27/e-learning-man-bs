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
        Schema::table('school_profile', function (Blueprint $table) {
            // Organization structure: array of positions with name, title, nip, photo
            $table->json('organization_structure')->nullable()->after('values');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profile', function (Blueprint $table) {
            $table->dropColumn('organization_structure');
        });
    }
};
