<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Subject;
use App\Models\Author;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $service;

    public function __construct(BookService $service){
        $this->service = $service;
    }

    public function index(Request $request){
        $query = Book::with(['authors', 'subjects']);

        if ($request->filled('titulo')) {
            $query->where('Titulo', 'like', "%{$request->titulo}%");
        }

        if ($request->filled('autor')) {
            $query->whereHas('authors', fn($q) => $q->where('CodAu', $request->autor));
        }

        if ($request->filled('assunto')) {
            $query->whereHas('subjects', fn($q) => $q->where('CodAs', $request->assunto));
        }

        return response()->json($query->orderBy('Codl')->paginate(10));
    }


    public function store(BookRequest $request){
        $book = $this->service->create($request->only(['Titulo','Editora','Edicao','AnoPublicacao','autor','assunto']));
        return response()->json($book, 201);
    }


    public function update(BookRequest $request, $id){
        $book = Book::findOrFail($id);
        $book = $this->service->update($book, $request->only(['Titulo','Editora','Edicao','AnoPublicacao','autor','assunto']));
        return response()->json($book, 200);
    }

    public function destroy($id){
        $book = Book::findOrFail($id);
        $this->service->delete($book);
        return response()->json(['message' => 'Livro deletado com sucesso']);
    }

    public function getAssuntos()
    {
        return Subject::select('codAs as value', 'Descricao as label')->get();
    }

    public function getAutores()
    {
        return Author::select('CodAu as value', 'Nome as label')->get();
    }
}
