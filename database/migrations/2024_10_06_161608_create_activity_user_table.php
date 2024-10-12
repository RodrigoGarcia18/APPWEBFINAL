<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID del usuario (estudiante)
            $table->unsignedBigInteger('activity_id'); // ID de la actividad asignada
            $table->timestamps(); // Fechas de creación y actualización

            // Relación con la tabla usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relación con la tabla activities
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_user');
    }
};
