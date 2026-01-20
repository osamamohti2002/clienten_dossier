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
        Schema::table('client_route', function (Blueprint $table) {
            $table->foreignId('client_zorg_moment_id')
                ->nullable()
                ->constrained('client_zorg_moments')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_route', function (Blueprint $table) {
            //
        });
    }
};
