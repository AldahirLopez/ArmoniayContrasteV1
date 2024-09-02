<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('certificado', function (Blueprint $table) {
            $table->id('id_certificado');
            $table->string('ruta_doc')->nullable();
            $table->unsignedBigInteger('id_servicio')->nullable();  // Asegúrate de que el tipo de dato coincida
            $table->timestamps();

            $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('certificado');
    }
};
