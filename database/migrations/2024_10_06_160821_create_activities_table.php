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
            $table->id(); 
            $table->string('activity_code')->unique(); 
            $table->string('name'); 
            $table->text('description')->nullable(); 
            $table->unsignedBigInteger('course_id'); // Relación con el curso
            $table->date('start_date');
            $table->date('end_date'); 
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
