<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;

class BookSeeder extends Seeder
{
    public function run()
    {
        $booksData = [
            ['Titulo' => 'O Pequeno Príncipe', 'Editora' => 'Record', 'Edicao' => '1', 'AnoPublicacao' => '1995', 'valor' => 50],
            ['Titulo' => 'Romeu E Julieta', 'Editora' => 'Darkside', 'Edicao' => '1', 'AnoPublicacao' => '1990', 'valor' => 60],
            ['Titulo' => 'Dom Quixote De La mancha', 'Editora' => 'Rocco', 'Edicao' => '1', 'AnoPublicacao' => '2003', 'valor' => 70],
            ['Titulo' => 'A Cabana', 'Editora' => 'HarperCollins ', 'Edicao' => '1', 'AnoPublicacao' => '2007', 'valor' => 80],
        ];

        $authors = Author::all();
        $subjects = Subject::all();

        foreach ($booksData as $index => $data) {
            $book = Book::create($data);

            $book->authors()->attach($authors[$index % $authors->count()]->CodAu);
            $book->subjects()->attach($subjects[$index % $subjects->count()]->codAs);
        }
    }
}
