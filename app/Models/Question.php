<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'time_limit'
    ];

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_questions')
                    ->withPivot('selected_option', 'is_correct', 'time_expired', 'time_spent')
                    ->withTimestamps();
    }
}