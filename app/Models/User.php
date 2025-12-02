<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;   // ← IMPORTANTE
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;   // ← IMPORTANTE

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function completedQuizzes()
    {
        return $this->hasMany(Quiz::class)->whereNotNull('completed_at');
    }

    public function getTotalScoreAttribute()
    {
        return $this->completedQuizzes()->sum('score');
    }

    public function getAccuracyAttribute()
    {
        $totalAnswers = $this->completedQuizzes()
            ->with('answers')
            ->get()
            ->pluck('answers')
            ->flatten()
            ->count();

        if ($totalAnswers == 0)
            return 0;

        $correctAnswers = $this->completedQuizzes()
            ->with('answers')
            ->get()
            ->pluck('answers')
            ->flatten()
            ->where('is_correct', true)
            ->count();

        return round(($correctAnswers / $totalAnswers) * 100);
    }

    public function getAverageTimeAttribute()
    {
        $quizzes = $this->completedQuizzes()->get();

        if ($quizzes->isEmpty())
            return null;

        $totalMinutes = $quizzes->sum(function ($quiz) {
            return $quiz->created_at->diffInMinutes($quiz->completed_at);
        });

        return round($totalMinutes / $quizzes->count());
    }
}
