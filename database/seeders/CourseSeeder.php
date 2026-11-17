<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Web Development',
                'description' => 'Learn HTML, CSS, JavaScript and modern web development.',
                'price' => 5000.00,
            ],
            [
                'name' => 'Python Programming',
                'description' => 'Learn Python fundamentals and practical programming.',
                'price' => 4500.00,
            ],
            [
                'name' => 'Database Management',
                'description' => 'Learn relational databases, SQL and data modelling.',
                'price' => 4000.00,
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['name' => $course['name']], $course);
        }
    }
}
