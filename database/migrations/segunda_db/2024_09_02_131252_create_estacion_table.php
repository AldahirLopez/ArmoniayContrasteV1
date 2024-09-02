<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('estacion', function (Blueprint $table) {
            $table->id('id_estacion');
            $table->string('num_estacion', 50)->nullable();
            $table->string('razon_social', 255)->nullable();
            $table->string('rfc', 20)->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->string('num_cree', 50)->nullable();
            $table->string('constancia', 50)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('correo', 255)->nullable();
            $table->string('contacto', 255)->nullable();
            $table->string('nombre_repre_legal', 255)->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('gruposmaca.users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('estacion');
    }
};
