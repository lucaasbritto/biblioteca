<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    protected function getToken(){
        $user = User::factory()->create([
            'email' => 'teste@example.com',
            'password' => bcrypt('password'),
        ]);

        return JWTAuth::fromUser($user);
    }

    public function test_can_create_book()
    {
        $author = Author::factory()->create();
        $subject = Subject::factory()->create();

        $payload = [
            'Titulo' => 'Livro Teste',
            'Editora' => 'Editora X',
            'Edicao' => '1',
            'AnoPublicacao' => '2023',
            'valor' => 100.50,
            'autor' => [$author->CodAu],
            'assunto' => [$subject->codAs],
        ];

        $response = $this->postJson('/api/books', $payload, [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', ['Titulo' => 'Livro Teste']);
        $this->assertDatabaseHas('livro_autor', ['Livro_Codl' => Book::first()->Codl, 'Autor_CodAu' => $author->CodAu]);
        $this->assertDatabaseHas('livro_assunto', ['Livro_Codl' => Book::first()->Codl, 'Assunto_CodAs' => $subject->codAs]);
    }

    public function test_can_list_books()
    {
        $book = Book::factory()->create();
        $response = $this->getJson('/api/books', [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['Titulo' => $book->Titulo]);
    }

    public function test_can_update_book()
    {
        $book = Book::factory()->create();
        $author = Author::factory()->create();
        $subject = Subject::factory()->create();

        $payload = [
            'Titulo' => 'Livro Atualizado',
            'Editora' => 'Editora Atualizada',
            'Edicao' => '2',
            'AnoPublicacao' => '2024',
            'valor' => 150.00,
            'autor' => [$author->CodAu],
            'assunto' => [$subject->codAs],
        ];

        $response = $this->putJson("/api/books/{$book->Codl}", $payload, [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', ['Codl' => $book->Codl, 'Titulo' => 'Livro Atualizado']);
        $this->assertDatabaseHas('livro_autor', ['Livro_Codl' => $book->Codl, 'Autor_CodAu' => $author->CodAu]);
        $this->assertDatabaseHas('livro_assunto', ['Livro_Codl' => $book->Codl, 'Assunto_CodAs' => $subject->codAs]);
    }

    public function test_can_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->Codl}", [], [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('books', ['Codl' => $book->Codl]);
    }
}
