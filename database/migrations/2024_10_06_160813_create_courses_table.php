<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); 
            $table->string('course_id')->unique(); 
            $table->string('name'); 
            $table->string('period'); 
            $table->string('session_link')->nullable(); //vacio al crearse, el docente asigna su enlace teams o zoom
            $table->text('description')->nullable();

            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
