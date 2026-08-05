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
        Schema::table('applicants', function (Blueprint $table) {
            // Free-text follow-up captured only when source is "Employee
            // Referral" (the referring employee's name) or "Other" (a
            // specify field) - one shared column since only one of those
            // two conditions can be true for a given source at a time.
            $table->string('source_detail')->nullable()->after('source_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('source_detail');
        });
    }
};
