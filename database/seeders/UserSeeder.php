<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([

            'name' => 'Usuário Teste',
            'email' => 'teste@quiz.com',
            'password' => Hash::make('password'),
            'total_score' => 0,
        ]);
    }
}