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

            if (!Schema::hasColumn('client_route', 'sequence')) {
                $table->unsignedInteger('sequence')->default(1)->after('client_zorg_moment_id');
            }

            if (!Schema::hasColumn('client_route', 'start_time')) {
                $table->time('start_time')->nullable()->after('sequence');
            }

            if (!Schema::hasColumn('client_route', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }

            // index (kan meerdere keren niet, maar meestal ok)
            $table->index(['route_id', 'sequence']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_route', function (Blueprint $table) {
            if (Schema::hasColumn('client_route', 'end_time')) {
                $table->dropColumn('end_time');
            }
            if (Schema::hasColumn('client_route', 'start_time')) {
                $table->dropColumn('start_time');
            }
            if (Schema::hasColumn('client_route', 'sequence')) {
                $table->dropColumn('sequence');
            }
        });
    }
};
