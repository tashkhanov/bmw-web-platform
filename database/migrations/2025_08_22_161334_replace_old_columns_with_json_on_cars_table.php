<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
        
        if (Schema::hasColumn('cars', 'colors')) $table->dropColumn('colors');
        if (Schema::hasColumn('cars', 'complectation')) $table->dropColumn('complectation');
        if (Schema::hasColumn('cars', 'interior')) $table->dropColumn('interior');
    });

    DB::statement("ALTER TABLE `cars` CHANGE `colors_json` `colors` JSON NULL;");
    DB::statement("ALTER TABLE `cars` CHANGE `complectation_json` `complectation` JSON NULL;");
    DB::statement("ALTER TABLE `cars` CHANGE `interior_json` `interior` JSON NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            //
        });
    }
};
