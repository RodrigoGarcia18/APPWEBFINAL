<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PagosSIGGASSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Generar registros de pagos
        for ($i = 0; $i < 50; $i++) { // Genera 50 registros de ejemplo
            DB::table('pagos_s_i_g_g_a_s')->insert([
                'numero_operacion' => 'OP-' . strtoupper(uniqid()), // Código de operación único
                'nombres' => $this->getRandomName(), // Generar un nombre aleatorio
                'apellidos' => $this->getRandomSurname(), // Generar un apellido aleatorio
                'monto_pago' => $this->generateRandomPayment(), // Monto de pago aleatorio
                'fecha_pago' => $this->generateRandomPaymentDate(), // Fecha de pago en los últimos 30 días
                'hora' => $this->generateRandomTime(), // Hora de pago
                'dni' => $this->generateDNI(), // Generar un DNI aleatorio
                'sucursal' => $this->getRandomBranch(), // Sucursal aleatoria
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Método para generar un nombre aleatorio
    private function getRandomName(): string
    {
        $names = ['Juan', 'María', 'José', 'Ana', 'Luis', 'Carmen', 'Pedro', 'Laura', 'Carlos', 'Lucía'];
        return $names[array_rand($names)];
    }

    // Método para generar un apellido aleatorio
    private function getRandomSurname(): string
    {
        $surnames = ['García', 'Rodríguez', 'Martínez', 'López', 'Hernández', 'Pérez', 'González', 'Díaz', 'Morales', 'Fernández'];
        return $surnames[array_rand($surnames)];
    }

    // Método para generar un DNI aleatorio
    private function generateDNI(): string
    {
        return str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT); // Generar un DNI de 8 dígitos
    }

    // Método para obtener una sucursal aleatoria
    private function getRandomBranch(): string
    {
        $branches = ['Sucursal 1', 'Sucursal 2', 'Sucursal 3', 'Sucursal 4', 'Sucursal 5'];
        return $branches[array_rand($branches)];
    }

    // Método para generar un monto de pago aleatorio
    private function generateRandomPayment(): float
    {
        return round(rand(1000, 50000) / 100, 2); // Monto de pago entre 10.00 y 500.00
    }

    // Método para generar una fecha de pago aleatoria en los últimos 30 días
    private function generateRandomPaymentDate(): string
    {
        return Carbon::now()->subDays(rand(0, 30))->toDateString(); // Devuelve solo la fecha
    }

    // Método para generar una hora aleatoria
    private function generateRandomTime(): string
    {
        return Carbon::now()->subHours(rand(0, 23))->format('H:i:s'); // Hora de pago
    }
}
