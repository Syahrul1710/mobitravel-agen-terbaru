<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->onDelete('set null');
            $table->string('slug')->unique()->after('name');
            $table->text('includes')->nullable(); // apa saja yang termasuk
            $table->text('excludes')->nullable(); // apa saja yang tidak termasuk
            $table->text('terms')->nullable(); // syarat & ketentuan
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
            $table->dropForeign(['destination_id']);
            $table->dropColumn([
                'destination_id', 'slug', 'includes', 'excludes', 'terms',
                'min_participants', 'max_participants', 'start_date', 'end_date',
                'is_open_trip', 'difficulty'
            ]);
        });
    }
};