<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $service;

    public function __construct(SubjectService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $subjects = $this->service->list($request->all(), $perPage);
        return response()->json($subjects);
    }

    public function store(SubjectRequest $request)
    {
        $subject = $this->service->create($request->validated());
        return response()->json($subject);
    }

    public function update(SubjectRequest $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject = $this->service->update($subject, $request->validated());
        return response()->json($subject);
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $this->service->delete($subject);
        return response()->json(['message' => 'Assunto excluído com sucesso']);
    }
}
