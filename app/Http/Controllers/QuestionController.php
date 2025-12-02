<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:4|max:4',
            'correct_answer' => 'required|string',
        ]);

        $question = Question::create($data);

        return response()->json([
            'message' => 'Pergunta criada com sucesso.',
            'question' => $question
        ], 201);
    }

    public function show(Question $question)
    {
        return $question;
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:4|max:4',
            'correct_answer' => 'required|string',
        ]);

        $question->update($data);

        return response()->json([
            'message' => 'Pergunta atualizada com sucesso.',
            'question' => $question
        ]);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json([
            'message' => 'Pergunta removida com sucesso.'
        ]);
    }
}