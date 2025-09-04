<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function list($filters = [], $perPage = 10)
    {
        $query = Author::query();

        if (!empty($filters['name'])) {
            $query->where('Nome', 'like', '%' . $filters['name'] . '%');
        }

        return $query->orderBy('CodAu')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Author::create([
            'Nome' => $data['name'],
        ]);
    }

    public function update(Author $author, array $data)
    {
        $author->update([
            'Nome' => $data['name'],
        ]);

        return $author;
    }

    public function delete(Author $author)
    {
        $author->delete();
        return true;
    }
}
