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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('car');
            $table->enum('category', ['sedans', 'crossovers', 'electrocars', 'm-series']);
            $table->string('fuel');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('image');
            $table->string('complectation')->nullable();
            $table->string('colors')->nullable();
            $table->string('interior')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};