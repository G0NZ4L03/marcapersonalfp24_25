<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Ciclo extends Model
{
    public function familiaProfesional(): BelongsTo
    {
        return $this->belongsTo(FamiliaProfesional::class, 'familia_id');
    }
    use HasFactory;

    protected $fillable = [
        'id',
        'codCiclo',
        'codFamilia',
        'familia_id',
        'grado',
        'nombre'
    ];

    public static $filterColumns = ['codCiclo', 'codFamilia', 'grado', 'nombre'];
}
