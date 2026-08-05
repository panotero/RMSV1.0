<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('lookup_lists')
            ->where('key', 'location')
            ->update(['key' => 'territory', 'label' => 'Territory']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('lookup_lists')
            ->where('key', 'territory')
            ->update(['key' => 'location', 'label' => 'Location']);
    }
};
