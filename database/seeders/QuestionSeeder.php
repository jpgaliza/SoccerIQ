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
                'option_a' => 'Ruby',
                'option_b' => 'Python',
                'option_c' => 'PHP',
                'option_d' => 'Java',
                'correct_option' => 'C',
            ],
            [
                'question' => 'Qual comando cria uma migration no Laravel?',
                'option_a' => 'php artisan make:migrate',
                'option_b' => 'php artisan migrate:make',
                'option_c' => 'php artisan make:migration',
                'option_d' => 'php artisan create:migration',
                'correct_option' => 'C',
            ],
            [
                'question' => 'Qual ORM o Laravel utiliza?',
                'option_a' => 'Eloquent',
                'option_b' => 'Hibernate',
                'option_c' => 'Doctrine',
                'option_d' => 'ActiveRecord',
                'correct_option' => 'A',
            ],
            [
                'question' => 'Qual comando inicia o servidor do Laravel?',
                'option_a' => 'php artisan run',
                'option_b' => 'php artisan start',
                'option_c' => 'php artisan serve',
                'option_d' => 'php artisan open',
                'correct_option' => 'C',
            ],
            [
                'question' => 'Qual arquivo define as rotas web no Laravel?',
                'option_a' => 'routes/api.php',
                'option_b' => 'routes/web.php',
                'option_c' => 'public/index.php',
                'option_d' => 'app/routes.php',
                'correct_option' => 'B',
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
