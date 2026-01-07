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
        Schema::create('client_route', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')
                    ->constrained('routes')
                    ->cascadeOnDelete();

            $table->foreignId('client_id')
                    ->constrained('clients')
                    ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['route_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_route');
    }
};
