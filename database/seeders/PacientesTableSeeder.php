<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Seeder;

class PacientesTableSeeder extends Seeder
{
    public function run()
    {
        $pacientes = [
            
            [
                'tipo_documento_id' => 1,
                'numero_documento' => '10000001',
                'nombre1' => 'Carlos',
                'nombre2' => 'Alberto',
                'apellido1' => 'Gómez',
                'apellido2' => 'Pérez',
                'genero_id' => 1, 
                'departamento_id' => 1, 
                'municipio_id' => 1, 
                'correo' => 'carlos.gomez@example.com',
            ],
            
          
            [
                'tipo_documento_id' => 1,
                'numero_documento' => '20000002',
                'nombre1' => 'Ana',
                'nombre2' => 'María',
                'apellido1' => 'Rodríguez',
                'apellido2' => 'López',
                'genero_id' => 2, 
                'departamento_id' => 2, 
                'municipio_id' => 3, 
                'correo' => 'ana.rodriguez@example.com',
            ],
            
           
            [
                'tipo_documento_id' => 2, 
                'numero_documento' => '30000003',
                'nombre1' => 'Jorge',
                'nombre2' => null,
                'apellido1' => 'Martínez',
                'apellido2' => 'García',
                'genero_id' => 1, 
                'departamento_id' => 3, 
                'municipio_id' => 5, 
                'correo' => 'jorge.martinez@example.com',
            ],
            
            
            [
                'tipo_documento_id' => 1, 
                'numero_documento' => '40000004',
                'nombre1' => 'Sofía',
                'nombre2' => 'Isabel',
                'apellido1' => 'Hernández',
                'apellido2' => null,
                'genero_id' => 2, 
                'departamento_id' => 4, 
                'municipio_id' => 7, 
                'correo' => 'sofia.hernandez@example.com',
            ],
            
           
            [
                'tipo_documento_id' => 1, 
                'numero_documento' => '50000005',
                'nombre1' => 'Luis',
                'nombre2' => 'Fernando',
                'apellido1' => 'Díaz',
                'apellido2' => 'Ramírez',
                'genero_id' => 1, 
                'departamento_id' => 5, 
                'municipio_id' => 9, 
                'correo' => 'luis.diaz@example.com',
            ]
        ];

        foreach ($pacientes as $paciente) {
            Paciente::create($paciente);
        }
    }
}