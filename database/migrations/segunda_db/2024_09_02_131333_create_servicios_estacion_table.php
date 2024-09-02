<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('servicios_estacion', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estacion')->nullable();
            $table->unsignedBigInteger('id_servicio')->nullable();
            $table->timestamps();

            $table->foreign('id_estacion')->references('id_estacion')->on('estacion')->onDelete('cascade');
            $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('servicios_estacion');
    }
};
