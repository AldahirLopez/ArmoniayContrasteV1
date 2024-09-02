<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('direcciones_estacion', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estacion')->nullable();
            $table->unsignedBigInteger('id_direccion')->nullable();
            $table->timestamps();

            $table->foreign('id_estacion')->references('id_estacion')->on('estacion')->onDelete('cascade');
            $table->foreign('id_direccion')->references('id_direccion')->on('direcciones')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('direcciones_estacion');
    }
};
