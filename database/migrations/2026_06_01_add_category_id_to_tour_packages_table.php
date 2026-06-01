<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('destination_id')->constrained('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropForeignIdFor('categories');
            $table->dropColumn('category_id');
        });
    }
};
