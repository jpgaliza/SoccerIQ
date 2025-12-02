<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Dados de overview do usuário atual
        $userStats = $this->getUserStats($user);

        // Ranking dos top jogadores
        $leaderboard = $this->getLeaderboard();

        return Inertia::render('Dashboard', [
            'overview' => $userStats,
            'leaderboard' => $leaderboard,
        ]);
    }

    private function getUserStats(User $user)
    {
        $completedQuizzes = $user->completedQuizzes()->get();
        $totalQuizzes = $completedQuizzes->count();

        if ($totalQuizzes == 0) {
            return [
                'rank' => null,
                'totalScore' => 0,
                'accuracy' => 0,
                'quizzesTaken' => 0,
            ];
        }

        $totalScore = $completedQuizzes->sum('score');

        // Calcular accuracy
        $totalAnswers = 0;
        $correctAnswers = 0;

        foreach ($completedQuizzes as $quiz) {
            $answers = $quiz->answers;
            $totalAnswers += $answers->count();
            $correctAnswers += $answers->where('is_correct', true)->count();
        }

        $accuracy = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100) : 0;

        // Calcular posição no ranking
        $rank = User::whereHas('completedQuizzes')
            ->withSum('completedQuizzes as total_score', 'score')
            ->having('total_score', '>', $totalScore)
            ->count() + 1;

        return [
            'rank' => $rank,
            'totalScore' => $totalScore,
            'accuracy' => $accuracy,
            'quizzesTaken' => $totalQuizzes,
        ];
    }

    private function getLeaderboard($limit = 10)
    {
        // Consulta otimizada com todas as agregações em uma única query
        $users = User::select([
            'users.id',
            'users.name',
            DB::raw('COALESCE(SUM(quizzes.score), 0) as total_score'),
            DB::raw('COUNT(quizzes.id) as completed_quizzes_count'),
            DB::raw('COALESCE(SUM(CASE WHEN quiz_answers.is_correct = 1 THEN 1 ELSE 0 END), 0) as correct_answers'),
            DB::raw('COUNT(quiz_answers.id) as total_answers'),
            DB::raw('ROUND(AVG(CASE WHEN quizzes.completed_at IS NOT NULL THEN 
                    (JULIANDAY(quizzes.completed_at) - JULIANDAY(quizzes.created_at)) * 24 * 60 
                    ELSE NULL END)) as avg_minutes')
        ])
            ->leftJoin('quizzes', function ($join) {
                $join->on('users.id', '=', 'quizzes.user_id')
                    ->whereNotNull('quizzes.completed_at');
            })
            ->leftJoin('quiz_answers', 'quizzes.id', '=', 'quiz_answers.quiz_id')
            ->groupBy('users.id', 'users.name')
            ->having('total_score', '>', 0)
            ->orderBy('total_score', 'desc')
            ->limit($limit)
            ->get();

        $leaderboard = [];

        foreach ($users as $index => $user) {
            $accuracy = $user->total_answers > 0
                ? round(($user->correct_answers / $user->total_answers) * 100)
                : 0;

            $averageTime = $user->avg_minutes
                ? sprintf('%d:%02d', intval(floor($user->avg_minutes / 60)), $user->avg_minutes % 60)
                : '—';

            $leaderboard[] = [
                'rank' => $index + 1,
                'player' => $user->name,
                'score' => (int) $user->total_score,
                'time' => $averageTime,
                'accuracy' => $accuracy,
            ];
        }

        return $leaderboard;
    }
}