<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function start()
    {
        $quiz = Quiz::create([
            'user_id' => auth()->id(),
            'score' => 0,
        ]);

        return response()->json([
            'message' => 'Quiz iniciado.',
            'quiz' => $quiz
        ]);
    }

    public function answer(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'user_answer' => 'required|string',
        ]);

        $question = Question::find($data['question_id']);
        $is_correct = $question->correct_answer === $data['user_answer'];

        QuizAnswer::create([
            'quiz_id' => $quiz->id,
            'question_id' => $data['question_id'],
            'user_answer' => $data['user_answer'],
            'is_correct' => $is_correct,
        ]);

        if ($is_correct) {
            $quiz->score += 10;
            $quiz->save();
        }

        return response()->json([
            'message' => 'Resposta registrada.',
            'is_correct' => $is_correct,
            'quiz' => $quiz
        ]);
    }

    public function finish(Quiz $quiz)
    {
        $quiz->update([
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Quiz finalizado.',
            'quiz' => $quiz
        ]);
    }

    public function ranking()
    {
        $ranking = Quiz::with('user')
            ->whereNotNull('completed_at')
            ->orderBy('score', 'DESC')
            ->orderBy('completed_at', 'ASC')
            ->limit(10)
            ->get()
            ->map(function ($quiz) {
                return [
                    'user_name' => $quiz->user->name,
                    'score' => $quiz->score,
                    'completed_at' => $quiz->completed_at->format('d/m/Y H:i'),
                ];
            });

        return response()->json([
            'ranking' => $ranking
        ]);
    }
}