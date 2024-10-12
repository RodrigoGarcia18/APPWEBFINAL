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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id(); // ID de la asistencia
            $table->unsignedBigInteger('user_id'); // ID del estudiante
            $table->unsignedBigInteger('course_id'); // ID del curso
            $table->date('attendance_date'); // Fecha de asistencia
            $table->enum('status', ['present', 'absent', 'late']); // Estado de la asistencia
            $table->timestamps(); // Fechas de creación y actualización

            // Relación con la tabla usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relación con la tabla courses
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
