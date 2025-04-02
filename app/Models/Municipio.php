<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = ['departamento_id', 'nombre'];

    // Relación con departamento
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    // Relación con pacientes
    public function pacientes(): HasMany
    {
        return $this->hasMany(Paciente::class);
    }
}