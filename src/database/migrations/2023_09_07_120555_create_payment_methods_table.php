<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id("intern_id");
            $table->string("id", 1)->unique();
            $table->string("name")->nullable(false);
            $table->decimal("tax", 8, 2, true);
        });

        DB::table('payment_methods')->insertOrIgnore([
            'id' => 'D',
            'name' => 'Cartão de Débito',
            'tax' => 3
        ]);
        DB::table('payment_methods')->insertOrIgnore([
            'id' => 'C',
            'name' => 'Cartão de Crédito',
            'tax' => 5
        ]);
        DB::table('payment_methods')->insertOrIgnore([
            'id' => 'P',
            'name' => 'Pix',
            'tax' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
