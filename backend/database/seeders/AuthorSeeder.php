<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            ['Nome' => 'Machado de Assis'],
            ['Nome' => 'William Shakespeare'],
            ['Nome' => 'Stephen King'],
            ['Nome' => 'Colleen Hoover'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
