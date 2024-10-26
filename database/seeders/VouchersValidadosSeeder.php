<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VouchersValidadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtener IDs de los vouchers y pagos
        $voucherIds = DB::table('vouchers')->pluck('id')->toArray();
        $pagosSigaIds = DB::table('pagos_s_i_g_g_a_s')->pluck('id')->toArray();

        // Generar registros de vouchers validados
        for ($i = 0; $i < 50; $i++) { // Generar 50 registros de ejemplo
            DB::table('vouchers_validados')->insert([
                'numero_operacion' => 'OP-' . strtoupper(uniqid()), // Número de operación único
                'fecha_pago' => Carbon::now()->subDays(rand(0, 30)), // Fecha de pago en los últimos 30 días
                'monto' => round(rand(1000, 50000) / 100, 2), // Monto aleatorio entre 10.00 y 500.00
                'dni_codigo' => $this->generateDNI(), // Generar un código de DNI aleatorio
                'nombres' => $this->getRandomName(), // Nombre aleatorio
                'apellidos' => $this->getRandomLastName(), // Apellido aleatorio
                'nombre_curso_servicio' => $this->getRandomCourseService(), // Curso o servicio aleatorio
                'estado' => rand(0, 1) === 1, // Estado aleatorio (true o false)
                'voucher_id' => $voucherIds[array_rand($voucherIds)], // Seleccionar un ID de voucher aleatorio
                'pagos_siga_id' => $pagosSigaIds[array_rand($pagosSigaIds)], // Seleccionar un ID de pago aleatorio
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

    // Método para obtener un nombre aleatorio
    private function getRandomName(): string
    {
        $names = ['Juan', 'María', 'Pedro', 'Luisa', 'Carlos', 'Ana', 'Jorge', 'Isabel'];
        return $names[array_rand($names)];
    }

    // Método para obtener un apellido aleatorio
    private function getRandomLastName(): string
    {
        $lastNames = ['García', 'Martínez', 'López', 'Hernández', 'Pérez', 'González'];
        return $lastNames[array_rand($lastNames)];
    }

    // Método para obtener un curso o servicio aleatorio
    private function getRandomCourseService(): string
    {
        $services = ['Curso de Matemáticas', 'Curso de Historia', 'Curso de Ciencias', 'Servicio de Tutoría'];
        return $services[array_rand($services)];
    }
}
