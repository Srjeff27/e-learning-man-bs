<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('school_profile', function (Blueprint $table) {
            $table->text('history')->nullable()->after('accreditation');
            $table->json('facilities')->nullable()->after('history');
            $table->string('school_photo')->nullable()->after('facilities');
        });
    }

    public function down(): void
    {
        Schema::table('school_profile', function (Blueprint $table) {
            $table->dropColumn(['history', 'facilities', 'school_photo']);
        });
    }
};
