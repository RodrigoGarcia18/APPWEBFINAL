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
        Schema::create('contador', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla users
            $table->string('first_name'); 
            $table->string('last_name'); // Apellido del docente
            $table->string('dni')->unique(); // DNI del docente
            $table->date('birth_date'); // Fecha de nacimiento
            $table->string('subject')->nullable(); // Materia en la que esta especializado
            $table->string('address')->nullable(); 
            $table->string('phone')->nullable(); 
            $table->string('profile_image')->nullable(); // URL de la imagen de perfil
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contador');
    }
};
