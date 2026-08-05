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
        Schema::table('recruitment_form_fields', function (Blueprint $table) {
            $table->foreignId('options_source_list_id')
                ->nullable()
                ->after('options')
                ->constrained('lookup_lists')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitment_form_fields', function (Blueprint $table) {
            $table->dropConstrainedForeignId('options_source_list_id');
        });
    }
};
