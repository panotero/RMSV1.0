<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lookup_lists', function (Blueprint $table) {
            // Nullable - most lists (e.g. Referral Source) are flat and have
            // no nested-child concept. Setting this is what turns on the
            // "add multiple child rows inline" UI for a list's top-level
            // items (e.g. Territory -> Location).
            $table->string('child_label')->nullable()->after('label');
        });

        DB::table('lookup_lists')->where('key', 'territory')->update(['child_label' => 'Location']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lookup_lists', function (Blueprint $table) {
            $table->dropColumn('child_label');
        });
    }
};
