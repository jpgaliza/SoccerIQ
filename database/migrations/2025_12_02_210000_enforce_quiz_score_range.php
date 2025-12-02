<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `quizzes` MODIFY `score` SMALLINT UNSIGNED NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE `quizzes` ADD CONSTRAINT `quizzes_score_range` CHECK (`score` BETWEEN 0 AND 1000)');
            DB::statement('UPDATE `quizzes` SET `score` = LEAST(GREATEST(`score`, 0), 1000)');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE quizzes ALTER COLUMN score TYPE SMALLINT');
            DB::statement('ALTER TABLE quizzes ALTER COLUMN score SET DEFAULT 0');
            DB::statement('ALTER TABLE quizzes ALTER COLUMN score SET NOT NULL');
            DB::statement('ALTER TABLE quizzes ADD CONSTRAINT quizzes_score_range CHECK (score BETWEEN 0 AND 1000)');
            DB::statement('UPDATE quizzes SET score = LEAST(GREATEST(score, 0), 1000)');
        } elseif ($driver === 'sqlite') {
            // SQLite não permite alterar o tipo diretamente; apenas normaliza os valores existentes
            DB::statement('UPDATE quizzes SET score = MIN(MAX(score, 0), 1000)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `quizzes` DROP CHECK `quizzes_score_range`');
            DB::statement('ALTER TABLE `quizzes` MODIFY `score` INT NOT NULL DEFAULT 0');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE quizzes DROP CONSTRAINT IF EXISTS quizzes_score_range');
            DB::statement('ALTER TABLE quizzes ALTER COLUMN score TYPE INTEGER');
            DB::statement('ALTER TABLE quizzes ALTER COLUMN score SET DEFAULT 0');
        }
        // Para SQLite não há necessidade de reversão explícita
    }
};
