<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDocumentoTableSeeder extends Seeder
{
    public function run()
    {
    
        DB::table('tipos_documento')->insert([
            ['nombre' => 'Cédula de Ciudadanía', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta de Identidad', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}