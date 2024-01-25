<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Student::create([
            'student_id' => '2013100819',
            'first_name' => 'Fred',
            'middle_name' => 'Polinar',
            'last_name' => 'Taran',
            'suffix' => '',
            'email' => 'ftaran04@gmail.com',
            'contact_number' => '09953835762',
            'course_id' => 1,
            'year_level' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
