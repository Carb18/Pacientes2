<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación con municipios
    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class);
    }

    // Relación con pacientes
    public function pacientes(): HasMany
    {
        return $this->hasMany(Paciente::class);
    }
}