<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;

    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';

    // Especificar la tabla asociada al modelo
    protected $table = 'estacion';

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'num_estacion',
        'razon_social',
        'rfc',
        'num_cre',
        'estado_id',
        'num_constancia',
        'telefono',
        'correo_electronico',
        'contacto',
        'nombre_representante_legal',
        'usuario_id',
    ];

}
