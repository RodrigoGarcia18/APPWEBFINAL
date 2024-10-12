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
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // ID de la actividad
            $table->string('activity_code')->unique(); // Código único para identificar la actividad
            $table->string('name'); // Nombre de la actividad
            $table->text('description')->nullable(); // Descripción de la actividad
            $table->unsignedBigInteger('course_id'); // Relación con el curso
            $table->date('start_date'); // Fecha de inicio de la actividad
            $table->date('end_date'); // Fecha de finalización de la actividad
            $table->timestamps(); // Fechas de creación y actualización

            // Relación con la tabla courses
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
