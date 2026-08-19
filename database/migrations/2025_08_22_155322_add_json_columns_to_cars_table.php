<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->json('colors_json')->nullable();
            $table->json('complectation_json')->nullable();
            $table->json('interior_json')->nullable();
        });

        $cars = DB::table('cars')->select('id','colors','complectation','interior')->get();

        foreach ($cars as $c) {
            $colors = $c->colors ? array_values(array_filter(array_map('trim', explode(',', $c->colors)))) : null;
            $comps  = $c->complectation ? array_values(array_filter(array_map('trim', explode(',', $c->complectation)))) : null;
            $inter  = $c->interior ? array_values(array_filter(array_map('trim', explode(',', $c->interior)))) : null;

            DB::table('cars')->where('id', $c->id)->update([
                'colors_json' => $colors ? json_encode($colors, JSON_UNESCAPED_UNICODE) : null,
                'complectation_json' => $comps ? json_encode($comps, JSON_UNESCAPED_UNICODE) : null,
                'interior_json' => $inter ? json_encode($inter, JSON_UNESCAPED_UNICODE) : null,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['colors_json','complectation_json','interior_json']);
        });
    }
};

