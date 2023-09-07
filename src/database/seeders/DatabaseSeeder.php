<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::connection("mysql");
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
}
