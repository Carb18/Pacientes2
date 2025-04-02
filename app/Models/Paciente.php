<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento_id',
        'numero_documento',
        'nombre1',
        'nombre2',
        'apellido1',
        'apellido2',
        'genero_id',
        'departamento_id',
        'municipio_id',
        'correo',
        'foto'
    ];

    // Relación con tipo de documento
    public function tipoDocumento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    // Relación con género
    public function genero(): BelongsTo
    {
        return $this->belongsTo(Genero::class);
    }

    // Relación con departamento
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    // Relación con municipio
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }
}