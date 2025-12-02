<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAnswer;
use Carbon\Carbon;

class RankingTestSeeder extends Seeder
{
    public function run(): void
    {
        // Criar algumas perguntas de exemplo se não existirem
        if (Question::count() == 0) {
            $questions = [
                [
                    'question' => 'Qual país sediou a Copa do Mundo de 2018?',
                    'options' => ['Brasil', 'Rússia', 'França', 'Alemanha'],
                    'correct_answer' => '1' // Index da opção correta (Rússia)
                ],
                [
                    'question' => 'Quantos jogadores tem uma equipe de futebol em campo?',
                    'options' => ['10', '11', '12', '9'],
                    'correct_answer' => '1' // Index da opção correta (11)
                ],
                [
                    'question' => 'Qual é o maior estádio do mundo?',
                    'options' => ['Maracanã', 'Camp Nou', 'May Day Stadium', 'Wembley'],
                    'correct_answer' => '2' // Index da opção correta (May Day Stadium)
                ],
                [
                    'question' => 'Em que ano foi realizada a primeira Copa do Mundo?',
                    'options' => ['1930', '1934', '1928', '1932'],
                    'correct_answer' => '0' // Index da opção correta (1930)
                ],
                [
                    'question' => 'Qual jogador possui mais títulos de Ballon d\'Or?',
                    'options' => ['Cristiano Ronaldo', 'Lionel Messi', 'Pelé', 'Maradona'],
                    'correct_answer' => '1' // Index da opção correta (Lionel Messi)
                ]
            ];

            foreach ($questions as $questionData) {
                Question::create($questionData);
            }
        }

        // Criar usuários de teste se não existirem
        $testUsers = [
            ['name' => 'João Silva', 'email' => 'joao@example.com'],
            ['name' => 'Maria Santos', 'email' => 'maria@example.com'],
            ['name' => 'Carlos Oliveira', 'email' => 'carlos@example.com'],
            ['name' => 'Ana Costa', 'email' => 'ana@example.com'],
            ['name' => 'Pedro Alves', 'email' => 'pedro@example.com'],
            ['name' => 'Lúcia Ferreira', 'email' => 'lucia@example.com']
        ];

        $questions = Question::all();

        foreach ($testUsers as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password'),
                    'email_verified_at' => now()
                ]
            );

            // Criar entre 2-5 quizzes para cada usuário
            $numQuizzes = rand(2, 5);

            for ($i = 0; $i < $numQuizzes; $i++) {
                $quiz = Quiz::create([
                    'user_id' => $user->id,
                    'score' => 0, // Será calculado baseado nas respostas
                    'completed_at' => Carbon::now()->subDays(rand(1, 30))->subMinutes(rand(5, 30))
                ]);

                // Criar respostas para 5 perguntas aleatórias
                $selectedQuestions = $questions->random(5);
                $correctAnswers = 0;

                foreach ($selectedQuestions as $question) {
                    // 70% de chance de acertar para dados realistas
                    $isCorrect = rand(1, 100) <= 70;
                    $userAnswer = $isCorrect ? $question->correct_answer : rand(0, 3);

                    QuizAnswer::create([
                        'quiz_id' => $quiz->id,
                        'question_id' => $question->id,
                        'user_answer' => (string) $userAnswer,
                        'is_correct' => $isCorrect
                    ]);

                    if ($isCorrect) {
                        $correctAnswers++;
                    }
                }

                // Atualizar score do quiz (100 pontos por resposta correta)
                $quiz->update(['score' => $correctAnswers * 10]);
            }
        }

        $this->command->info('Dados de teste para ranking criados com sucesso!');
    }
}
