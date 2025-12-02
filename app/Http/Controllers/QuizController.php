<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        // Buscar 10 perguntas aleatórias
        $questions = Question::inRandomOrder()
            ->limit(10)
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'options' => collect($question->options)->map(function ($option, $index) {
                        return [
                            'id' => (string) $index,
                            'label' => chr(65 + $index), // A, B, C, D
                            'text' => $option
                        ];
                    })->toArray(),
                    'correct' => $question->correct_answer,
                ];
            });

        return Inertia::render('Quiz', [
            'questions' => $questions
        ]);
    }

    public function start(Request $request)
    {
        $quiz = Quiz::create([
            'user_id' => auth()->id(),
            'score' => 0,
        ]);

        return response()->json([
            'quiz_id' => $quiz->id,
            'message' => 'Quiz iniciado com sucesso'
        ]);
    }

    public function answer(Request $request)
    {
        $data = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_id' => 'required|exists:questions,id',
            'user_answer' => 'required|string',
            'time_taken' => 'required|integer|min:0|max:30', // segundos
        ]);

        $quiz = Quiz::findOrFail($data['quiz_id']);

        // Verificar se o quiz pertence ao usuário autenticado
        if ($quiz->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $question = Question::find($data['question_id']);
        $is_correct = $question->correct_answer === $data['user_answer'];

        // Calcular pontuação baseada no tempo (máximo 100 pontos)
        $score = 0;
        if ($is_correct) {
            $timeTaken = $data['time_taken'];
            $maxTime = 30; // 30 segundos máximo
            $minScore = 50; // pontuação mínima para resposta correta
            $maxScore = 100; // pontuação máxima

            // Quanto mais rápido, mais pontos (linear)
            $timeBonus = max(0, $maxTime - $timeTaken) / $maxTime;
            $score = $minScore + ($maxScore - $minScore) * $timeBonus;
            $score = round($score);
        }

        QuizAnswer::create([
            'quiz_id' => $quiz->id,
            'question_id' => $data['question_id'],
            'user_answer' => $data['user_answer'],
            'is_correct' => $is_correct,
        ]);

        $quiz->score += $score;
        $quiz->save();

        return response()->json([
            'is_correct' => $is_correct,
            'points_earned' => $score,
            'total_score' => $quiz->score
        ]);
    }

    public function finish(Request $request)
    {
        $data = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id'
        ]);

        $quiz = Quiz::findOrFail($data['quiz_id']);

        // Verificar se o quiz pertence ao usuário autenticado
        if ($quiz->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $quiz->update([
            'completed_at' => now(),
        ]);

        // Calcular estatísticas do quiz
        $totalQuestions = $quiz->answers()->count();
        $correctAnswers = $quiz->answers()->where('is_correct', true)->count();
        $accuracy = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        return response()->json([
            'message' => 'Quiz finalizado com sucesso!',
            'quiz' => [
                'id' => $quiz->id,
                'score' => $quiz->score,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'accuracy' => $accuracy,
                'completed_at' => $quiz->completed_at->format('d/m/Y H:i')
            ]
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