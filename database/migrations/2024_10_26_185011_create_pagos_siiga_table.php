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
        Schema::create('pagos_s_i_g_g_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('numero_operacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->decimal('monto_pago', 8, 2);
            $table->dateTime('fecha_pago');
            $table->time('hora'); 
            $table->string('dni');
            $table->string('sucursal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_s_i_g_g_a_s');
    }
};
