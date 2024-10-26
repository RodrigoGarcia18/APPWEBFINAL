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
        Schema::create('matriculados', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni')->unique();
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');
            $table->foreignId('matricula_id')->constrained('matriculas')->onDelete('cascade');
            $table->foreignId('voucher_validado_id')->nullable()->constrained('vouchers_validados')->onDelete('cascade');
            
            // Clave foránea para users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculados');
    }
};
