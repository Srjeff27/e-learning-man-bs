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
            $table->json('missions')->nullable()->after('mission'); // Array of {title, description}
            $table->json('values')->nullable()->after('missions');  // Array of {title, description}
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profile', function (Blueprint $table) {
            $table->dropColumn(['missions', 'values']);
        });
    }
};
