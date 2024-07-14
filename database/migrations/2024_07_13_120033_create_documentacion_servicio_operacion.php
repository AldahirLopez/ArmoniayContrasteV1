<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('segunda_db')->create('documentacion_servicio_operacion', function (Blueprint $table) {
            $table->id();
            $table->string('rutadoc_estacion');
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            // Agregar la clave foránea
            $table->foreign('usuario_id')->references('id')->on('gruposmaca.users');
            // Agregar la clave foránea
            $table->foreign('servicio_id')->references('id')->on('armonia.estacion_servicio_operacion_mantenimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentacion_servicio_operacion');
    }
};
