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
            $table->foreignId('role_id')->nullable()->after('location_id')->constrained('lookup_list_items')->nullOnDelete();
            $table->foreignId('source_id')->nullable()->after('role_id')->constrained('lookup_list_items')->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('interview_summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
            $table->dropConstrainedForeignId('source_id');
            $table->dropColumn(['phone', 'email', 'date_of_birth', 'interview_summary']);
        });
    }
};
