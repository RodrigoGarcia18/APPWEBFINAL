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
        Schema::create('notas', function (Blueprint $table) {
            $table->id(); // ID de la nota
            $table->unsignedBigInteger('activity_submission_id'); // ID de la entrega
            $table->decimal('nota', 5, 2); // Nota de la actividad
            $table->foreign('activity_submission_id')->references('id')->on('activity_submissions')->onDelete('cascade'); // Relación con activity_submissions
            $table->timestamps(); // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas'); // Cambiado de 'grades' a 'notas'
    }
};
