<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{
    public function run()
    {
        $departamentos = [
            ['nombre' => 'Cundinamarca'],
            ['nombre' => 'Antioquia'],
            ['nombre' => 'Valle del Cauca'],
            ['nombre' => 'Santander'],
            ['nombre' => 'Boyacá'],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
    }
}