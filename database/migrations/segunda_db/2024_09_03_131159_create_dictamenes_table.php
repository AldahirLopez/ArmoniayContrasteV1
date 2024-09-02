<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('segunda_db')->create('dictamenes', function (Blueprint $table) {
            $table->id('id_dictamen');
            $table->string('nomenclatura', 50)->nullable();
            $table->string('tipo_dictamen', 50)->nullable();
            $table->string('ruta_doc', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('segunda_db')->dropIfExists('dictamenes');
    }
};
