<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $service;

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $authors = $this->service->list($request->all(), $perPage);
        return response()->json($authors);
    }

    public function store(AuthorRequest $request)
    {
        $author = $this->service->create($request->validated());
        return response()->json($author);
    }


    public function update(AuthorRequest $request, $id)
    {
        $author = Author::findOrFail($id);
        $author = $this->service->update($author, $request->validated());
        return response()->json($author);
    }


    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $this->service->delete($author);
        return response()->json(['message' => 'Autor excluído com sucesso']);
    }
}
