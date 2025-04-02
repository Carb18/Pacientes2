<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    // Obtener todos los pacientes (con relaciones)
    public function index()
    {
        $pacientes = Paciente::with(['tipoDocumento', 'genero', 'departamento', 'municipio'])->get();
        return response()->json($pacientes);
    }

    // Crear nuevo paciente
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'numero_documento' => 'required|unique:pacientes|max:20',
            'nombre1' => 'required|max:50',
            'nombre2' => 'nullable|max:50',
            'apellido1' => 'required|max:50',
            'apellido2' => 'nullable|max:50',
            'genero_id' => 'required|exists:generos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'correo' => 'required|email|unique:pacientes',
            'foto' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $paciente = Paciente::create($request->all());
        return response()->json($paciente, 201);
    }

    // Mostrar un paciente específico
    public function show($id)
    {
        $paciente = Paciente::with(['tipoDocumento', 'genero', 'departamento', 'municipio'])->find($id);
        
        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }
        
        return response()->json($paciente);
    }

    // Actualizar paciente
    public function update(Request $request, $id)
    {
        $paciente = Paciente::find($id);
        
        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tipo_documento_id' => 'exists:tipos_documento,id',
            'numero_documento' => 'unique:pacientes,numero_documento,'.$id.'|max:20',
            'nombre1' => 'max:50',
            'nombre2' => 'nullable|max:50',
            'apellido1' => 'max:50',
            'apellido2' => 'nullable|max:50',
            'genero_id' => 'exists:generos,id',
            'departamento_id' => 'exists:departamentos,id',
            'municipio_id' => 'exists:municipios,id',
            'correo' => 'email|unique:pacientes,correo,'.$id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $paciente->update($request->all());
        return response()->json($paciente);
    }

    // Eliminar paciente
    public function destroy($id)
    {
        $paciente = Paciente::find($id);
        
        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $paciente->delete();
        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }

    // Método adicional: Buscar por número de documento
    public function buscarPorDocumento($documento)
    {
        $paciente = Paciente::where('numero_documento', $documento)->first();
        return $paciente ? response()->json($paciente) : response()->json(['message' => 'No encontrado'], 404);
    }
}