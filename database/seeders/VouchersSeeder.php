<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VouchersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Generar registros de vouchers
        for ($i = 0; $i < 50; $i++) { // Genera 50 registros de ejemplo
            DB::table('vouchers')->insert([
                'fecha' => Carbon::now()->subDays(rand(0, 30)), // Fecha en los últimos 30 días
                'hora' => Carbon::now()->subHours(rand(0, 23))->format('H:i:s'), // Hora del voucher
                'operacion' => 'OP-' . strtoupper(uniqid()), // Número de operación único
                'monto' => round(rand(1000, 50000) / 100, 2), // Monto del voucher entre 10.00 y 500.00
                'codigo_dni' => $this->generateDNI(), // Generar un código de DNI aleatorio
                'servicio' => $this->getRandomService(), // Servicio aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Método para generar un código de DNI aleatorio
    private function generateDNI(): string
    {
        return str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT); // Generar un DNI de 8 dígitos
    }

    // Método para obtener un servicio aleatorio
    private function getRandomService(): string
    {
        $services = ['Servicio A', 'Servicio B', 'Servicio C', 'Servicio D', 'Servicio E'];
        return $services[array_rand($services)];
    }
}
