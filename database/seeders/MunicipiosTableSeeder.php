<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;

class MunicipiosTableSeeder extends Seeder
{
    public function run()
    {
        $municipiosPorDepartamento = [
            // Cundinamarca (ID 1)
            [
                ['nombre' => 'Bogotá D.C.'],
                ['nombre' => 'Soacha']
            ],
            // Antioquia (ID 2)
            [
                ['nombre' => 'Medellín'],
                ['nombre' => 'Envigado']
            ],
            // Valle del Cauca (ID 3)
            [
                ['nombre' => 'Cali'],
                ['nombre' => 'Palmira']
            ],
            // Santander (ID 4)
            [
                ['nombre' => 'Bucaramanga'],
                ['nombre' => 'Floridablanca']
            ],
            // Boyacá (ID 5)
            [
                ['nombre' => 'Tunja'],
                ['nombre' => 'Duitama']
            ]
        ];

        foreach ($municipiosPorDepartamento as $departamentoId => $municipios) {
            foreach ($municipios as $municipio) {
                Municipio::create([
                    'departamento_id' => $departamentoId + 1, // +1 porque los arrays empiezan en 0
                    'nombre' => $municipio['nombre']
                ]);
            }
        }
    }
}