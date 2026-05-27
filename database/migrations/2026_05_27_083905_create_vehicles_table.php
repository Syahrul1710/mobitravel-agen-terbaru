<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
            $table->string('name'); // Nama kendaraan (Toyota Avanza, dll)
            $table->string('type'); // MPV, SUV, Minibus, Bus
            $table->string('plate_number')->unique(); // Nomor plat
            $table->integer('capacity'); // Kapasitas penumpang
            $table->text('facilities')->nullable(); // AC, music, dll
            $table->string('photo')->nullable(); // Foto kendaraan
            $table->integer('price_with_driver'); // Harga dengan sopir
            $table->integer('price_without_driver'); // Harga tanpa sopir
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};