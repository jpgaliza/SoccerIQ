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
        $completedQuizzes = $user->completedQuizzes()->with('answers')->get();
        $totalQuizzes = $completedQuizzes->count();

        if ($totalQuizzes == 0) {
            return [
                'rank' => null,
                'bestScore' => 0,
                'accuracy' => 0,
                'quizzesTaken' => 0,
            ];
        }

        // Encontrar o melhor quiz (maior score, menor tempo como desempate)
        $bestQuiz = $completedQuizzes
            ->sort(function ($a, $b) {
                if ($a->score === $b->score) {
                    return ($a->total_time_seconds ?? PHP_INT_MAX) <=> ($b->total_time_seconds ?? PHP_INT_MAX);
                }
                return $b->score <=> $a->score;
            })
            ->first();

        // Calcular accuracy do melhor quiz
        $answers = $bestQuiz->answers;
        $totalAnswers = $answers->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $accuracy = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100) : 0;

        // Calcular posição no ranking baseada no melhor score com mesmo critério da tabela
        $rankedUsers = $this->buildRankedUsers();
        $rank = $rankedUsers->search(fn($entry) => $entry['user_id'] === $user->id);
        $rank = $rank === false ? null : $rank + 1;

        return [
            'rank' => $rank,
            'bestScore' => $bestQuiz->score,
            'accuracy' => $accuracy,
            'quizzesTaken' => $totalQuizzes,
        ];
    }

    private function getLeaderboard($limit = 30)
    {
        $users = $this->buildRankedUsers()
            ->take($limit)
            ->values();

        $leaderboard = [];

        foreach ($users as $index => $user) {
            $hasTime = is_int($user['time_seconds']) && $user['time_seconds'] !== PHP_INT_MAX;
            $timeFormatted = $hasTime
                ? sprintf('%d:%02d', intval(floor($user['time_seconds'] / 60)), $user['time_seconds'] % 60)
                : '—';

            $leaderboard[] = [
                'rank' => $index + 1,
                'player' => $user['name'],
                'score' => (int) $user['best_score'],
                'time' => $timeFormatted,
                'accuracy' => $user['accuracy'],
            ];
        }

        return $leaderboard;
    }

    private function buildRankedUsers()
    {
        return User::whereHas('completedQuizzes')
            ->with(['completedQuizzes.answers'])
            ->get()
            ->map(function ($user) {
                $completedQuizzes = $user->completedQuizzes;

                if ($completedQuizzes->isEmpty()) {
                    return null;
                }

                $bestQuiz = $completedQuizzes
                    ->sort(function ($a, $b) {
                        if ($a->score === $b->score) {
                            return ($a->total_time_seconds ?? PHP_INT_MAX) <=> ($b->total_time_seconds ?? PHP_INT_MAX);
                        }
                        return $b->score <=> $a->score;
                    })
                    ->first();

                $answers = $bestQuiz->answers;
                $totalAnswers = $answers->count();
                $correctAnswers = $answers->where('is_correct', true)->count();
                $accuracy = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100) : 0;

                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'best_score' => $bestQuiz->score,
                    'accuracy' => $accuracy,
                    'time_seconds' => $bestQuiz->total_time_seconds ?? PHP_INT_MAX,
                ];
            })
            ->filter(function ($user) {
                return $user && $user['best_score'] > 0;
            })
            ->sort(function ($a, $b) {
                if ($a['best_score'] === $b['best_score']) {
                    return ($a['time_seconds'] ?? PHP_INT_MAX) <=> ($b['time_seconds'] ?? PHP_INT_MAX);
                }
                return $b['best_score'] <=> $a['best_score'];
            })
            ->values();
    }
}