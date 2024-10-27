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
        Schema::create('vouchers_validados', function (Blueprint $table) {
            $table->id();
            $table->string('numero_operacion');
            $table->dateTime('fecha_pago');
            $table->decimal('monto', 8, 2);
            $table->string('dni_codigo');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nombre_curso_servicio');
            $table->boolean('estado')->default(false);
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->unsignedBigInteger('pagos_siga_id')->nullable();

            $table->timestamps();
            
            // Definición de las claves foráneas
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('pagos_siga_id')->references('id')->on('pagos_s_i_g_g_a_s')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers_validados');
    }
};
