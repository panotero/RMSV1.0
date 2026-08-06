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
            $table->foreignId('territory_id')->nullable()->after('location_id')->constrained('lookup_list_items')->nullOnDelete();
            $table->timestamp('interview_date')->nullable()->after('interview_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropConstrainedForeignId('territory_id');
            $table->dropColumn('interview_date');
        });
    }
};
