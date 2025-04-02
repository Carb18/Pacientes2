<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TiposDocumentoTableSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            ['nombre' => 'Cédula de Ciudadanía'],
            ['nombre' => 'Tarjeta de Identidad'],
        ];

        TipoDocumento::insert($tipos);
    }
}