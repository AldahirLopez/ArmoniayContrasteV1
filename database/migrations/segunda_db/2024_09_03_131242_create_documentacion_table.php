<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('documentacion', function (Blueprint $table) {
            $table->id('id_documentacion');
            $table->string('ruta_doc', 255)->nullable();
            $table->unsignedBigInteger('id_servicio')->nullable();
            $table->timestamps();

            $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('documentacion');
    }
};
