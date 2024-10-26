<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OrganizationsTableSeeder::class, // Seeder para organizaciones
            UsersTableSeeder::class, // Seeder para usuarios
            TeachersTableSeeder::class, // Seeder para profesores
            StudentsTableSeeder::class, // Seeder para estudiantes
            CoursesTableSeeder::class, // Seeder para cursos
            CourseUserTableSeeder::class, // Seeder para la relación entre cursos y usuarios
            ActivitiesTableSeeder::class, // Seeder para actividades
            ActivitiesSubmissionsTableSeeder::class, // Seeder para envíos de actividades
            GradesTableSeeder::class, // Seeder para calificaciones
            AttendanceTableSeeder::class, // Seeder para asistencia
            RegistrosSeeder::class, // Seeder para registros de estudiantes
            MatriculasSeeder::class, // Seeder para matrículas
            MatriculadosSeeder::class, // Seeder para estudiantes matriculados
            VouchersSeeder::class, // Seeder para vouchers
            PagosSIGGASSeeder::class, // Seeder para pagos S.I.G.G.A.S
            VouchersValidadosSeeder::class, // Seeder para vouchers validados
            CertificadosTableSeeder::class, // Seeder para certificados
            UserCertificadosTableSeeder::class, // Seeder para relación usuario-certificados
        ]);
    }
}
