<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación con pacientes
    public function pacientes(): HasMany
    {
        return $this->hasMany(Paciente::class);
    }
}