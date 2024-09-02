<?php


namespace App\Models\Estados;

use App\Models\Direccion;
use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $connection = 'segunda_db';  // Conexión a la segunda base de datos
    protected $table = 'states';  // Nombre de la tabla

    protected $primaryKey = 'id';  // Clave primaria

    // Relación con Municipios (uno a muchos)
    public function municipios()
    {
        return $this->hasMany(Municipios::class, 'id_state');
    }

    // Relación con Direcciones (uno a muchos)
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'entidad_federativa_id');
    }
}
