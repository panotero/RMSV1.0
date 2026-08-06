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
        Schema::create('applicant_orientation_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_orientation_id')
                ->constrained('applicant_orientations')
                ->cascadeOnDelete();
            // 'scheduled' - the first time a date is set. 'rescheduled' -
            // every time after that the date actually changes.
            $table->string('event_type');
            $table->date('scheduled_date');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_orientation_history');
    }
};
