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

        // Crear la tabla user_certificados
        Schema::create('user_certificados', function (Blueprint $table) {
            $table->id(); // ID de la relación
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clave foránea para usuarios
            $table->decimal('nota_final', 8, 2);
            $table->foreignId('certificado_id')->constrained('certificados')->onDelete('cascade'); // Clave foránea para certificados
            $table->date('fecha_obtencion')->nullable(); // Fecha en la que el usuario obtuvo el certificado
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_certificados');
    }
};
