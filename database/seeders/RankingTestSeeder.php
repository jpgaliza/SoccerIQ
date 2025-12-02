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
        // Remover usuários indesejados do ranking
        User::where('email', 'user@test.com')
            ->orWhere('name', 'Usuario Logado')
            ->orWhere('name', 'Usuário Logado')
            ->delete();

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
            ['name' => 'Lúcia Ferreira', 'email' => 'lucia@example.com'],
            ['name' => 'Bruno Silva', 'email' => 'bruno@example.com'],
            ['name' => 'Carla Mendes', 'email' => 'carla@example.com'],
            ['name' => 'Diego Santos', 'email' => 'diego@example.com'],
            ['name' => 'Elena Rodrigues', 'email' => 'elena@example.com'],
            ['name' => 'Felipe Costa', 'email' => 'felipe@example.com'],
            ['name' => 'Gabriela Lima', 'email' => 'gabriela@example.com'],
            ['name' => 'Hugo Pereira', 'email' => 'hugo@example.com'],
            ['name' => 'Isabela Martins', 'email' => 'isabela@example.com'],
            ['name' => 'Júlio Fernandes', 'email' => 'julio@example.com'],
            ['name' => 'Kelly Barbosa', 'email' => 'kelly@example.com'],
            ['name' => 'Leonardo Souza', 'email' => 'leonardo@example.com'],
            ['name' => 'Mariana Gomes', 'email' => 'mariana@example.com'],
            ['name' => 'Nicolas Almeida', 'email' => 'nicolas@example.com'],
            ['name' => 'Olivia Cardoso', 'email' => 'olivia@example.com']
        ];

        $questions = Question::all();
        $questionCount = min(10, $questions->count());

        if ($questionCount < 4) {
            $this->command?->warn('Não há perguntas suficientes para gerar o ranking de teste. Execute o FootballQuestionsSeeder primeiro.');
            return;
        }

        // Precisões possíveis: múltiplos de 10 de 10% a 100%
        $possibleAccuracies = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
        
        foreach ($testUsers as $index => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password'),
                    'email_verified_at' => now()
                ]
            );

            // Cada usuário terá entre 3-6 quizzes
            $numQuizzes = rand(3, 6);

            for ($i = 0; $i < $numQuizzes; $i++) {
                $quiz = Quiz::create([
                    'user_id' => $user->id,
                    'score' => 0,
                    'total_time_seconds' => 0,
                    'completed_at' => Carbon::now()->subDays(rand(1, 30))->subMinutes(rand(5, 30))
                ]);

                $selectedQuestions = $questions->random($questionCount);
                
                // Escolher uma precisão específica múltipla de 10
                $targetAccuracyPercent = $possibleAccuracies[array_rand($possibleAccuracies)];
                $correctAnswersNeeded = (int) round(($targetAccuracyPercent / 100) * $questionCount);
                
                $totalScore = 0;
                $totalTimeSeconds = 0;
                $correctCount = 0;
                $questionIndex = 0;

                foreach ($selectedQuestions as $question) {
                    $questionIndex++;
                    $responseTime = rand(8, 25); // Tempo de resposta variado
                    $totalTimeSeconds += $responseTime;

                    // Determinar se deve ser correta baseado na precisão desejada
                    $remainingQuestions = $questionCount - $questionIndex + 1;
                    $correctsStillNeeded = $correctAnswersNeeded - $correctCount;
                    
                    if ($correctsStillNeeded >= $remainingQuestions) {
                        // Precisa acertar esta e todas as restantes
                        $isCorrect = true;
                    } elseif ($correctsStillNeeded <= 0) {
                        // Já atingiu o número necessário
                        $isCorrect = false;
                    } else {
                        // Distribuir aleatoriamente as corretas restantes
                        $isCorrect = rand(1, $remainingQuestions) <= $correctsStillNeeded;
                    }

                    $userAnswer = $this->determineUserAnswer($question, $isCorrect);

                    QuizAnswer::create([
                        'quiz_id' => $quiz->id,
                        'question_id' => $question->id,
                        'user_answer' => $userAnswer,
                        'is_correct' => $isCorrect
                    ]);

                    if ($isCorrect) {
                        $correctCount++;
                        $speedFactor = max(0, 30 - $responseTime) / 30;
                        $points = (int) round(50 + (50 * $speedFactor));
                        $totalScore += $points;
                    }
                }

                $quiz->update([
                    'score' => min(1000, $totalScore),
                    'total_time_seconds' => max(60, $totalTimeSeconds),
                ]);
            }
        }

        $this->command->info('Dados de teste para ranking criados com sucesso!');
    }

    private function determineUserAnswer(Question $question, bool $isCorrect): string
    {
        $correctAnswer = (string) $question->correct_answer;

        if ($isCorrect) {
            return $correctAnswer;
        }

        $options = collect($question->options ?? []);
        $isIndexBased = ctype_digit($correctAnswer);

        if ($isIndexBased) {
            $optionPool = collect(range(0, max(0, $options->count() - 1)))
                ->map(fn($value) => (string) $value)
                ->reject(fn($value) => $value === $correctAnswer)
                ->values();
        } else {
            $optionPool = $options
                ->reject(fn($value) => (string) $value === $correctAnswer)
                ->values();
        }

        if ($optionPool->isEmpty()) {
            return $correctAnswer;
        }

        return (string) $optionPool->random();
    }
}
