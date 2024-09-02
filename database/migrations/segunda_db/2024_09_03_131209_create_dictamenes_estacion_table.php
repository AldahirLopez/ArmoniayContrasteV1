<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('dictamenes_estacion', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estacion')->nullable();
            $table->unsignedBigInteger('id_dictamen')->nullable();
            $table->timestamps();

            $table->foreign('id_estacion')->references('id_estacion')->on('estacion')->onDelete('cascade');
            $table->foreign('id_dictamen')->references('id_dictamen')->on('dictamenes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('dictamenes_estacion');
    }
};
