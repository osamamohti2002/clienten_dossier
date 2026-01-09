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
        Schema::table('client_route', function (Blueprint $table) {
            $table->foreignId('zorgpersoneel_id')
                ->nullable() 
                ->after('client_id')
                ->constrained('zorg_personeel')
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('client_route', function (Blueprint $table) {
            $table->dropForeign(['zorgpersoneel_id']);
            $table->dropColumn('zorgpersoneel_id');
        });
    }
};
