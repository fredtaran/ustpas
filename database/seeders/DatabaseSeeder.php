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
            // [
            //     'first_name' => 'Fred',
            //     'last_name' => 'Taran',
            //     'email' => 'ftaran100411@gmail.com',
            //     'username' => 'fred.taran',
            //     'role' => 2,
            //     'password' => bcrypt('@dmin123'),
            // ],
            // [
            //     'first_name' => 'April Rose',
            //     'last_name' => 'Legaspi',
            //     'email' => 'a@mail.com',
            //     'username' => 'aprilrose.legaspi',
            //     'role' => 2,
            //     'password' => bcrypt('@dmin123'),
            // ],
            // [
            //     'first_name' => 'Dean 1',
            //     'last_name' => 'Dean 1',
            //     'email' => 'b@mail.com',
            //     'username' => 'dean1.dean1',
            //     'role' => 3,
            //     'password' => bcrypt('@dmin123'),
            // ],
            // [
            //     'first_name' => 'Dean 2',
            //     'last_name' => 'Dean 2',
            //     'email' => 'c@mail.com',
            //     'username' => 'dean2.dean2',
            //     'role' => 3,
            //     'password' => bcrypt('@dmin123'),
            // ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'utpas2024@gmail.com',
                'username' => 'system.admin',
                'role' => 0,
                'password' => bcrypt('@dmin123'),
            ]
        ];

        \App\Models\User::insert($data);

        $this->call([
            // CourseSeeder::class,
            // SubjectSeeder::class,
            // StudentSeeder::class,
            // TorSeeder::class
        ]);
    }
}
