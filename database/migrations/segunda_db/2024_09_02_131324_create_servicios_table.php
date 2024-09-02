<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('servicios', function (Blueprint $table) {
            $table->id('id_servicio');  // Esto crea un campo de tipo unsignedBigInteger
            $table->string('nomenclatura', 50)->nullable();
            $table->unsignedInteger('tipo_servicio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('servicios');
    }
};
