<?php

namespace App\Models;

use App\Models\Estados\Estados;
use App\Models\Estados\Municipios;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $connection = 'segunda_db';  // Conexión a la segunda base de datos
    protected $table = 'direcciones';  // Nombre de la tabla

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'tipo_direccion',
        'calle',
        'numero_ext',
        'numero_int',
        'colonia',
        'codigo_postal',
        'localidad_id',
        'municipio_id',
        'entidad_federativa_id',
        'id_estacion'
    ];

    // Relación con Estacion (inversa, uno a muchos)
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion');
    }

    // Relación con Municipio (muchos a uno)
    public function municipio()
    {
        return $this->belongsTo(Municipios::class, 'municipio_id');
    }

    // Relación con Estado (muchos a uno)
    public function estado()
    {
        return $this->belongsTo(Estados::class, 'entidad_federativa_id');
    }
}
