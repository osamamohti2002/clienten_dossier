<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('routes', function (Blueprint $table) {
        // 1. Drop foreign key first
        $table->dropForeign(['zorgpersoneel_id']);

        // 2. Drop unique index
        $table->dropUnique('routes_zorgpersoneel_id_unique');

        // 3. Re-add foreign key WITHOUT unique
        $table->foreign('zorgpersoneel_id')
              ->references('id')
              ->on('zorg_personeel')
              ->cascadeOnDelete();
    });
}

public function down()
{
    Schema::table('routes', function (Blueprint $table) {
        // Rollback: drop FK
        $table->dropForeign(['zorgpersoneel_id']);

        // Re-add unique index
        $table->unique('zorgpersoneel_id');

        // Re-add FK
        $table->foreign('zorgpersoneel_id')
              ->references('id')
              ->on('zorg_personeel')
              ->cascadeOnDelete();
    });
}
};