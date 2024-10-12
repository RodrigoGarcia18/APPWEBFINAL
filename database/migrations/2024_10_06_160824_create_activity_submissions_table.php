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
        Schema::create('activity_submissions', function (Blueprint $table) {
            $table->id(); // ID de la sumisión
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Cambia 'usuarios' por 'users'
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade'); // Asegúrate de que 'activities' también esté correctamente configurada
            $table->string('filepath')->nullable(); // Campo filepath, vacío por defecto
            $table->text('text_content')->nullable(); // Campo text_content, vacío por defecto
            $table->timestamps(); // Fechas de creación y actualización
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_submissions');
    }
};
