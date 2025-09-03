<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Subject;
use App\Models\Author;

class BookController extends Controller
{
    public function index(Request $request){
        $query = Book::with(['authors', 'subjects']);

        if ($request->filled('titulo')) {
            $query->where('Titulo', 'like', "%{$request->titulo}%");
        }

        if ($request->filled('autor')) {
            $query->whereHas('authors', function ($q) use ($request) {
                $q->where('Nome', 'like', "%{$request->autor}%");
            });
        }
        
        if ($request->filled('assunto')) {
            $query->whereHas('subjects', function ($q) use ($request) {
                $q->where('Descricao', $request->assunto);
            });
        }

        $books = $query->orderBy('Codl', 'asc')->paginate(10);

        return response()->json([
            'data' => $books->items(),
            'current_page' => $books->currentPage(),
            'last_page' => $books->lastPage(),
            'per_page' => $books->perPage(),
            'total' => $books->total(),
        ]);
    }

    public function getAssuntos()
    {
        return Subject::select('Descricao as label', 'Descricao as value')->get();
    }

    public function getAutores()
    {
        return Author::select('Nome as label', 'Nome as value')->get();
    }
    
}
