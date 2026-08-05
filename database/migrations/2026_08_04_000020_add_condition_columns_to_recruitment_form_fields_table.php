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
            $table->string('condition_field_key')->nullable()->after('help_text');
            $table->string('condition_value')->nullable()->after('condition_field_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitment_form_fields', function (Blueprint $table) {
            $table->dropColumn(['condition_field_key', 'condition_value']);
        });
    }
};
