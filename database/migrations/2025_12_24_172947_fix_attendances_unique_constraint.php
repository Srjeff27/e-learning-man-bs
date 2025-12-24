<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Fix: Change unique constraint from (classroom_id, student_id, date) 
     * to (session_id, student_id) so multiple sessions on same day don't conflict.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Drop old unique constraint (classroom_id + student_id + date)
            $table->dropUnique(['classroom_id', 'student_id', 'date']);

            // Add new unique constraint (session_id + student_id)
            // This allows multiple sessions per day with separate attendance records
            $table->unique(['session_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Remove new unique constraint
            $table->dropUnique(['session_id', 'student_id']);

            // Restore old unique constraint
            $table->unique(['classroom_id', 'student_id', 'date']);
        });
    }
};
