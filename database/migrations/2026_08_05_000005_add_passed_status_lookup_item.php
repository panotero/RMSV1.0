<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Inserts "Passed" between "Interview" and "Orientation" in the
     * 'status' lookup list - the interview Pass outcome now lands here
     * first, and checklist-group completion is what advances a passed
     * applicant on to "Orientation" (or wherever else a group targets).
     */
    public function up(): void
    {
        $list = DB::table('lookup_lists')->where('key', 'status')->first();

        if (!$list) {
            return;
        }

        $alreadyExists = DB::table('lookup_list_items')
            ->where('lookup_list_id', $list->id)
            ->where('name', 'Passed')
            ->exists();

        if ($alreadyExists) {
            return;
        }

        // Shift Orientation/Offer/Hired/Rejected (order >= 4) down by one to
        // make room for Passed at order 4.
        DB::table('lookup_list_items')
            ->where('lookup_list_id', $list->id)
            ->where('order', '>=', 4)
            ->increment('order');

        DB::table('lookup_list_items')->insert([
            'lookup_list_id' => $list->id,
            'parent_id' => null,
            'name' => 'Passed',
            'order' => 4,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $list = DB::table('lookup_lists')->where('key', 'status')->first();

        if (!$list) {
            return;
        }

        DB::table('lookup_list_items')
            ->where('lookup_list_id', $list->id)
            ->where('name', 'Passed')
            ->delete();

        DB::table('lookup_list_items')
            ->where('lookup_list_id', $list->id)
            ->where('order', '>', 4)
            ->decrement('order');
    }
};
