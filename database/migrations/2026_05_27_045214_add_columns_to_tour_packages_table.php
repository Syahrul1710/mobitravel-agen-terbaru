<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->text('includes')->nullable();
            $table->text('excludes')->nullable();
            $table->text('terms')->nullable();
            $table->integer('min_participants')->default(1);
            $table->integer('max_participants')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_open_trip')->default(true);
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
        });
    }

    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn([
                'includes', 'excludes', 'terms',
                'min_participants', 'max_participants', 'start_date', 'end_date',
                'is_open_trip', 'difficulty'
            ]);
        });
    }
};