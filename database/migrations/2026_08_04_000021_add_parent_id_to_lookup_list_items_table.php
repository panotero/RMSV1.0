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
        Schema::table('lookup_list_items', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('lookup_list_id')
                ->constrained('lookup_list_items')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lookup_list_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
        });
    }
};
