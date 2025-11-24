<?php
// app/Models/Quiz.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score', 
        'correct_answers',
        'time_spent',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    // Método SIMPLES para finalizar quiz
    public function complete($correctAnswers, $totalTime)
    {
        $score = $correctAnswers * 10; // Cada acerto = 10 pontos
        
        $this->update([
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'time_spent' => $totalTime,
            'completed_at' => now()
        ]);

        // Atualiza score total do usuário
        $this->user->increment('total_score', $score);
    }
}