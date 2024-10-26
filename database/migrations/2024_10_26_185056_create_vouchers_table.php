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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha'); // Fecha del voucher
            $table->time('hora'); // Hora del voucher
            $table->string('operacion'); // Número de operación
            $table->decimal('monto', 8, 2); // Monto del voucher
            $table->string('codigo_dni'); // Código de DNI
            $table->string('servicio'); // Servicio asociado al voucher
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
