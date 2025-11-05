<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'name' => 'John Smith',
            'email' => 'john.smith@student.edu',
            'course' => 'Computer Science',
            'marks' => 85.50,
            'status' => 'active'
        ]);

        Student::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.j@student.edu', 
            'course' => 'Mathematics',
            'marks' => 92.00,
            'status' => 'active'
        ]);

        Student::create([
            'name' => 'Mike Brown',
            'email' => 'mike.brown@student.edu',
            'course' => 'Physics',
            'marks' => 78.50,
            'status' => 'inactive'
        ]);

        Student::create([
            'name' => 'Emily Davis',
            'email' => 'emily.davis@student.edu',
            'course' => 'Chemistry',
            'marks' => 88.75,
            'status' => 'active'
        ]);

        Student::create([
            'name' => 'David Wilson',
            'email' => 'david.wilson@student.edu',
            'course' => 'Biology',
            'marks' => 91.25,
            'status' => 'active'
        ]);
    }
}