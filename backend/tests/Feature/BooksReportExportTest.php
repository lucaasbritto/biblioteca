<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;

class BooksReportExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_download_books_report()
    {
        $author = Author::factory()->create(['Nome' => 'Autor Teste']);
        $subject = Subject::factory()->create(['Descricao' => 'Assunto Teste']);
        $book = Book::factory()->create(['Titulo' => 'Livro Teste']);

        $book->authors()->attach($author->CodAu);
        $book->subjects()->attach($subject->codAs);

        $response = $this->getJson('/api/report/books', [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

        $response->assertStatus(200);
        $this->assertEquals(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            $response->headers->get('content-type')
        );
    }

    private function getToken()
    {
        $user = \App\Models\User::factory()->create();
        return auth()->login($user);
    }
}
