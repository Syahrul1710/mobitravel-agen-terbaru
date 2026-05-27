<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('travel_requests', function (Blueprint $table) {
            $table->string('selected_route_id')->nullable()->after('vehicle_id');
            $table->string('selected_pickup')->nullable()->after('selected_route_id');
            $table->string('selected_dropoff')->nullable()->after('selected_pickup');
            $table->boolean('with_driver')->default(true)->after('selected_dropoff');
        });
    }

    public function down(): void
    {
        Schema::table('travel_requests', function (Blueprint $table) {
            $table->dropColumn(['selected_route_id', 'selected_pickup', 'selected_dropoff', 'with_driver']);
        });
    }
};