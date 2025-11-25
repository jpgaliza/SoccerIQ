<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'question_text' => 'Qual é a capital do Brasil?',
                'option_a' => 'Rio de Janeiro',
                'option_b' => 'Brasília',
                'option_c' => 'São Paulo',
                'option_d' => 'Salvador',
                'correct_option' => 'b',
                'time_limit' => 20
            ],
            [
                'question_text' => '2 + 2 = ?',
                'option_a' => '3',
                'option_b' => '4',
                'option_c' => '5',
                'option_d' => '6',
                'correct_option' => 'b',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Qual linguagem é usada em navegadores web?',
                'option_a' => 'Python',
                'option_b' => 'Java',
                'option_c' => 'JavaScript',
                'option_d' => 'C++',
                'correct_option' => 'c',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Quantos lados tem um triângulo?',
                'option_a' => '2',
                'option_b' => '3',
                'option_c' => '4',
                'option_d' => '5',
                'correct_option' => 'b',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Qual é a cor do céu em um dia claro?',
                'option_a' => 'Verde',
                'option_b' => 'Vermelho',
                'option_c' => 'Azul',
                'option_d' => 'Amarelo',
                'correct_option' => 'c',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Quem escreveu "Dom Casmurro"?',
                'option_a' => 'Machado de Assis',
                'option_b' => 'José de Alencar',
                'option_c' => 'Carlos Drummond',
                'option_d' => 'Clarice Lispector',
                'correct_option' => 'a',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Qual é o maior planeta do sistema solar?',
                'option_a' => 'Terra',
                'option_b' => 'Júpiter',
                'option_c' => 'Saturno',
                'option_d' => 'Marte',
                'correct_option' => 'b',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Quantos dias tem uma semana?',
                'option_a' => '5',
                'option_b' => '6',
                'option_c' => '7',
                'option_d' => '8',
                'correct_option' => 'c',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Qual é o oposto de "dia"?',
                'option_a' => 'Tarde',
                'option_b' => 'Noite',
                'option_c' => 'Manhã',
                'option_d' => 'Sol',
                'correct_option' => 'b',
                'time_limit' => 20
            ],
            [
                'question_text' => 'Que animal é conhecido como "rei da selva"?',
                'option_a' => 'Elefante',
                'option_b' => 'Leão',
                'option_c' => 'Tigre',
                'option_d' => 'Girafa',
                'correct_option' => 'b',
                'time_limit' => 20
            ]
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}