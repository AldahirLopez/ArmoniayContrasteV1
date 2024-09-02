<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('direcciones', function (Blueprint $table) {
            $table->id('id_direccion');
            $table->string('tipo_direccion', 50)->nullable();
            $table->string('calle', 255)->nullable();
            $table->string('numero_ext', 10)->nullable();
            $table->string('numero_int', 10)->nullable();
            $table->string('colonia', 255)->nullable();
            $table->unsignedInteger('codigo_postal')->nullable();
            $table->string('localidad_id', 50)->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('entidad_federativa_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('direcciones');
    }
};
