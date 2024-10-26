<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserCertificadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtener todos los IDs de los usuarios y certificados
        $userIds = DB::table('users')->pluck('id')->toArray();
        $certificadoIds = DB::table('certificados')->pluck('id')->toArray();

        // Crear registros de user_certificados
        foreach ($userIds as $userId) {
            // Asignar un certificado aleatorio a cada usuario
            $certificadoId = $certificadoIds[array_rand($certificadoIds)];

            DB::table('user_certificados')->insert([
                'user_id' => $userId,
                'certificado_id' => $certificadoId,
                'nota_final' => round(rand(50, 100) / 10, 2), // Nota aleatoria entre 5.00 y 10.00
                'fecha_obtencion' => Carbon::now()->subDays(rand(0, 30)), // Fecha de obtención en los últimos 30 días
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
