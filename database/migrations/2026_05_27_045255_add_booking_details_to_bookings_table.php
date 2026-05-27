<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Cek dan tambah hanya jika kolom belum ada
            if (!Schema::hasColumn('bookings', 'booking_code')) {
                $table->string('booking_code')->unique()->after('id');
            }
            
            if (!Schema::hasColumn('bookings', 'travel_date')) {
                $table->date('travel_date')->nullable();
            }
            
            if (!Schema::hasColumn('bookings', 'participants')) {
                $table->integer('participants')->default(1);
            }
            
            if (!Schema::hasColumn('bookings', 'sub_total')) {
                $table->integer('sub_total');
            }
            
            if (!Schema::hasColumn('bookings', 'tax')) {
                $table->integer('tax')->default(0);
            }
            
            if (!Schema::hasColumn('bookings', 'special_requests')) {
                $table->text('special_requests')->nullable();
            }
            
            if (!Schema::hasColumn('bookings', 'payment_proof')) {
                $table->string('payment_proof')->nullable();
            }
            
            if (!Schema::hasColumn('bookings', 'paid_at')) {
                $table->timestamp('paid_at')->nullable();
            }
            
            if (!Schema::hasColumn('bookings', 'expired_at')) {
                $table->timestamp('expired_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'booking_code', 'travel_date', 'participants', 'sub_total',
                'tax', 'special_requests', 'payment_proof', 'paid_at', 'expired_at'
            ]);
        });
    }
};