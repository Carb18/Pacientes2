<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DepartamentosTableSeeder::class,
            MunicipiosTableSeeder::class,
            GenerosTableSeeder::class,
            TiposDocumentoTableSeeder::class,
            PacientesTableSeeder::class,
            UsersTableSeeder::class,
            
        ]);
    }
}