<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();

            // relaties
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // type: weight | blood_pressure | temperature | blood_sugar
            $table->string('type');

            // Gewicht + lengte
            $table->decimal('weight_kg', 5, 2)->nullable();   // bv 72.50
            $table->unsignedSmallInteger('height_cm')->nullable(); // bv 180

            // Bloeddruk
            $table->unsignedSmallInteger('systolic')->nullable();   // bovendruk
            $table->unsignedSmallInteger('diastolic')->nullable();  // onderdruk
            $table->unsignedSmallInteger('heart_rate')->nullable(); // hartslag

            // Temperatuur
            $table->decimal('temperature_c', 4, 1)->nullable(); // bv 37.5

            // Bloedsuiker
            $table->decimal('blood_sugar', 4, 1)->nullable(); // bv 6.8

            $table->timestamps();

            // index voor sneller filteren per client/type
            $table->index(['client_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};