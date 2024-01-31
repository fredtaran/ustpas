<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $data = [
            [
                'first_name' => 'April Rose',
                'last_name' => 'Legaspi',
                'email' => 'ftaran100411@gmail.com',
                'username' => 'aprilrose.legaspi',
                'role' => 2,
                'password' => bcrypt('@dmin123'),
            ],
            [
                'first_name' => 'Fred',
                'last_name' => 'Taran',
                'email' => 'ftaran04@gmail.com',
                'username' => 'fred.taran',
                'role' => 1,
                'password' => bcrypt('@dmin123'),
            ]
        ];

        \App\Models\User::insert($data);

        $this->call([
            CourseSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            TorSeeder::class
        ]);
    }
}
