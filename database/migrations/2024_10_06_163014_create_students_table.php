<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // ID del estudiante
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla users
            $table->string('first_name'); // Nombre del estudiante
            $table->string('last_name'); // Apellido del estudiante
            $table->string('dni')->unique(); // DNI del estudiante
            $table->date('birth_date'); // Fecha de nacimiento
            $table->string('enrollment_number')->nullable(); // Número de matrícula
            $table->string('address')->nullable(); // Dirección del estudiante
            $table->string('phone')->nullable(); // Teléfono del estudiante
            $table->string('profile_image')->nullable(); // URL de la imagen de perfil
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
