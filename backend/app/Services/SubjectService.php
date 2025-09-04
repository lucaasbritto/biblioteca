<?php

namespace App\Services;

use App\Models\Subject;

class SubjectService
{
    public function list($filters = [], $perPage = 10)
    {
        $query = Subject::query();

        if (!empty($filters['name'])) {
            $query->where('Descricao', 'like', '%' . $filters['name'] . '%');
        }

        return $query->orderBy('codAs')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Subject::create([
            'Descricao' => $data['name'],
        ]);
    }

    public function update(Subject $subject, array $data)
    {
        $subject->update([
            'Descricao' => $data['name'],
        ]);

        return $subject;
    }

    public function delete(Subject $subject)
    {
        $subject->delete();
        return true;
    }
}
