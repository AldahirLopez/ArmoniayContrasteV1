<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('usuario_estacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('estacion_id');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('gruposmaca.users')->onDelete('cascade');
            $table->foreign('estacion_id')->references('id_estacion')->on('estacion')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('usuario_estacion');
    }
};
