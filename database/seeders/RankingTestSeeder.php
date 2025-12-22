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
        User::where('email', 'user@test.com')
            ->orWhere('name', 'Usuario Logado')
            ->orWhere('name', 'Usuário Logado')
            ->delete();


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
            $this->command?->warn('Not enough questions to generate test ranking. Run FootballQuestionsSeeder first.');
            return;
        }

        // Possible accuracies: multiples of 10 from 10% to 100%
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

            // Each user will have between 3-6 quizzes
            $numQuizzes = rand(3, 6);

            for ($i = 0; $i < $numQuizzes; $i++) {
                $quiz = Quiz::create([
                    'user_id' => $user->id,
                    'score' => 0,
                    'total_time_seconds' => 0,
                    'completed_at' => Carbon::now()->subDays(rand(1, 30))->subMinutes(rand(5, 30))
                ]);

                $selectedQuestions = $questions->random($questionCount);

                // Choose a specific accuracy multiple of 10
                $targetAccuracyPercent = $possibleAccuracies[array_rand($possibleAccuracies)];
                $correctAnswersNeeded = (int) round(($targetAccuracyPercent / 100) * $questionCount);

                $totalScore = 0;
                $totalTimeSeconds = 0;
                $correctCount = 0;
                $questionIndex = 0;

                foreach ($selectedQuestions as $question) {
                    $questionIndex++;
                    $responseTime = rand(8, 25); // Varied response time
                    $totalTimeSeconds += $responseTime;

                    // Determine if answer should be correct based on desired accuracy
                    $remainingQuestions = $questionCount - $questionIndex + 1;
                    $correctsStillNeeded = $correctAnswersNeeded - $correctCount;

                    if ($correctsStillNeeded >= $remainingQuestions) {
                        // Must get this and all remaining correct
                        $isCorrect = true;
                    } elseif ($correctsStillNeeded <= 0) {
                        // Already reached required number
                        $isCorrect = false;
                    } else {
                        // Randomly distribute remaining correct answers
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

        $this->command->info('Test ranking data created successfully!');
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
