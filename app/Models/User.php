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
        'total_score',
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
}
