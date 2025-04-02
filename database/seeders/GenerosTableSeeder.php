<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Seeder;

class GenerosTableSeeder extends Seeder
{
    public function run()
    {
        $generos = [
            ['nombre' => 'Masculino'],
            ['nombre' => 'Femenino'],
        ];

        Genero::insert($generos);
    }
}