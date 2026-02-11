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
        Schema::table('session_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('athlete_id')->after('coach_id');
            $table->foreign('athlete_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('duration')->after('end_time'); // in minutes
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled')->after('duration');
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_schedules', function (Blueprint $table) {
            $table->dropForeign('session_schedules_athlete_id_foreign');
            $table->dropColumn(['athlete_id', 'duration', 'status', 'notes']);
        });
    }
};
