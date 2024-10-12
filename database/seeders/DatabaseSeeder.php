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
            OrganizationsTableSeeder::class,
            UsersTableSeeder::class,
            TeachersTableSeeder::class,
            StudentsTableSeeder::class,
            CoursesTableSeeder::class,
            CourseUserTableSeeder::class,
            ActivitiesTableSeeder::class,
            ActivitiesSubmissionsTableSeeder::class,
            GradesTableSeeder::class,
            AttendanceTableSeeder::class,
        ]);
    }
}
