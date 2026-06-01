<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'departure_date')) {
                $table->date('departure_date')->nullable()->after('expired_at');
            }
            if (!Schema::hasColumn('bookings', 'passengers')) {
                $table->integer('passengers')->default(1)->after('departure_date');
            }
            if (!Schema::hasColumn('bookings', 'platform_fee')) {
                $table->bigInteger('platform_fee')->default(0)->after('passengers');
            }
            if (!Schema::hasColumn('bookings', 'total_amount')) {
                $table->bigInteger('total_amount')->default(0)->after('platform_fee');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumnIfExists(['departure_date', 'passengers', 'platform_fee', 'total_amount']);
        });
    }
};