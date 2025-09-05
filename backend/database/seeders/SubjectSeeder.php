<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            ['Descricao' => 'Drama'],
            ['Descricao' => 'Romance'],
            ['Descricao' => 'Literatura'],
            ['Descricao' => 'Fantasia'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
