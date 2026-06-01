<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('destinations', function (Blueprint $table) {
        $table->foreignId('tour_package_id')->nullable()->constrained('tour_packages')->nullOnDelete();
    });
}

public function down()
{
    Schema::table('destinations', function (Blueprint $table) {
        $table->dropForeign(['tour_package_id']);
        $table->dropColumn('tour_package_id');
    });
}
};
