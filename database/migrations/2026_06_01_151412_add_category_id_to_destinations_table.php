<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('province', 100)->nullable()->after('location');
            $table->string('city', 100)->nullable()->after('province');
            $table->decimal('latitude', 10, 8)->nullable()->after('city');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('status')->default('active')->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['province', 'city', 'latitude', 'longitude', 'status']);
        });
    }
};