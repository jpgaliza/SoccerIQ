<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'question' => 'Qual linguagem o Laravel utiliza?',
                'options' => ['Ruby', 'Python', 'PHP', 'Java'],
                'correct_answer' => 'PHP',
            ],
            [
                'question' => 'Qual comando cria uma migration no Laravel?',
                'options' => ['php artisan make:migrate', 'php artisan migrate:make', 'php artisan make:migration', 'php artisan create:migration'],
                'correct_answer' => 'php artisan make:migration',
            ],
            [
                'question' => 'Qual ORM o Laravel utiliza?',
                'options' => ['Eloquent', 'Hibernate', 'Doctrine', 'ActiveRecord'],
                'correct_answer' => 'Eloquent',
            ],
            [
                'question' => 'Qual comando inicia o servidor do Laravel?',
                'options' => ['php artisan run', 'php artisan start', 'php artisan serve', 'php artisan open'],
                'correct_answer' => 'php artisan serve',
            ],
            [
                'question' => 'Qual arquivo define as rotas web no Laravel?',
                'options' => ['routes/api.php', 'routes/web.php', 'public/index.php', 'app/routes.php'],
                'correct_answer' => 'routes/web.php',
            ],
            [
                'question' => 'Quantos estados tem o Brasil?',
                'options' => ['26', '27', '25', '28'],
                'correct_answer' => '27',
            ],
            [
                'question' => 'Qual é a capital do Brasil?',
                'options' => ['Rio de Janeiro', 'São Paulo', 'Brasília', 'Salvador'],
                'correct_answer' => 'Brasília',
            ],
            [
                'question' => 'Qual é o maior planeta do sistema solar?',
                'options' => ['Terra', 'Júpiter', 'Saturno', 'Marte'],
                'correct_answer' => 'Júpiter',
            ],
            [
                'question' => 'Quem escreveu "Dom Casmurro"?',
                'options' => ['Machado de Assis', 'Carlos Drummond', 'Clarice Lispector', 'Jorge Amado'],
                'correct_answer' => 'Machado de Assis',
            ],
            [
                'question' => 'Qual é a fórmula da água?',
                'options' => ['H2O', 'CO2', 'NaCl', 'O2'],
                'correct_answer' => 'H2O',
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}