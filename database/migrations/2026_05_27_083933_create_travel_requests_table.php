<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('set null');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->date('travel_date');
            $table->time('pickup_time');
            $table->integer('passengers');
            $table->boolean('need_driver')->default(true);
            $table->integer('suggested_price')->nullable(); // Harga yang diajukan user
            $table->integer('final_price')->nullable(); // Harga final dari agen
            $table->enum('status', [
                'pending',      // Menunggu respon agen
                'negotiating',  // Agen menawarkan harga
                'approved',     // Disetujui agen
                'rejected',     // Ditolak agen
                'confirmed',    // Dikonfirmasi user
                'completed',    // Selesai
                'cancelled'     // Dibatalkan
            ])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};