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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('zorgpersoneel_id')
                    ->constrained('zorg_personeel')
                    ->cascadeOnDelete();

            $table->unique('zorgpersoneel_id'); // ✅ correct place

            $table->date('datum');
            $table->enum('shift', ['ochtend', 'avond']);
            $table->time('starttijd');
            $table->time('eindtijd');

            // Voorkom dat dezelfde persoon op dezelfde dag een dubbele shift draait.
            $table->unique(['zorgpersoneel_id', 'datum', 'shift']);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
