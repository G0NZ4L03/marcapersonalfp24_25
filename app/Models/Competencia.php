<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    protected $table = 'competencias';

    protected $fillable = [
        'id',
        'nombre',
        'color'

    ];

    public static $filterColumns = ['id', 'nombre', 'color'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_competencias')
            ->withPivot('docente_validador');
    }
}
