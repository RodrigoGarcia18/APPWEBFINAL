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
        Schema::create('registros', function (Blueprint $table) {
            $table->id(); // ID del registro
            $table->string('nombres'); // Nombres del estudiante
            $table->string('apellidos'); // Apellidos del estudiante
            $table->string('dni')->unique(); // DNI del estudiante
            $table->string('celular'); // Celular del estudiante
            $table->integer('edad'); // Edad del estudiante
            $table->string('sexo'); // Sexo del estudiante
            $table->date('fecha_nacimiento'); // Fecha de nacimiento
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
