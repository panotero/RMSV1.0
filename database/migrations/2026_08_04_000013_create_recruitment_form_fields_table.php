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
        Schema::create('recruitment_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('recruitment_forms')->cascadeOnDelete();
            $table->string('field_key');
            $table->string('label');
            $table->string('type');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('file_rules')->nullable();
            $table->string('help_text')->nullable();
            $table->timestamps();

            $table->unique(['form_id', 'field_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_form_fields');
    }
};
