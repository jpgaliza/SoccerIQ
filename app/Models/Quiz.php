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

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions')
                    ->withPivot('selected_option', 'is_correct', 'time_expired', 'time_spent')
                    ->withTimestamps();
    }
}