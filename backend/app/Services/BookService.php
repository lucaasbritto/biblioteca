<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function create(array $data): Book
    {
        $book = Book::create($data);
        if (isset($data['autor'])) {
            $book->authors()->sync($data['autor']);
        }
        if (isset($data['assunto'])) {
            $book->subjects()->sync($data['assunto']);
        }
        return $book->load('authors', 'subjects');
    }

    public function update(Book $book, array $data): Book
    {
        $book->update($data);
        if (isset($data['autor'])) {
            $book->authors()->sync($data['autor']);
        }
        if (isset($data['assunto'])) {
            $book->subjects()->sync($data['assunto']);
        }
        return $book->load('authors', 'subjects');
    }

    public function delete(Book $book): void
    {
        $book->delete();
    }
}
