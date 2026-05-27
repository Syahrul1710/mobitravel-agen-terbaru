<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('tour_package_id')->nullable()->constrained('tour_packages')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->integer('participants')->default(1); // jumlah peserta
            $table->integer('total_price');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('midtrans_order_id')->nullable(); // dari Midtrans
            $table->timestamp('expired_at')->nullable(); // kadaluwarsa 24 jam
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['tour_package_id']);
            $table->dropColumn([
                'tour_package_id', 'customer_name', 'customer_email', 'customer_phone',
                'participants', 'total_price', 'payment_status', 'payment_method',
                'midtrans_order_id', 'expired_at', 'paid_at'
            ]);
        });
    }
};