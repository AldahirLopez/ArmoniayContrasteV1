<?php

namespace App\Models\Estados;

use App\Models\Direccion;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    protected $connection = 'segunda_db';  // Conexión a la segunda base de datos
    protected $table = 'municipalities';  // Nombre de la tabla

    protected $primaryKey = 'id';  // Clave primaria

    // Campos que se pueden llenar masivamente
    protected $fillable = ['id_state', 'description'];

    // Relación con Estado (muchos a uno)
    public function estado()
    {
        return $this->belongsTo(Estados::class, 'id_state');
    }

    // Relación con Direcciones (uno a muchos)
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'municipio_id');
    }
}
