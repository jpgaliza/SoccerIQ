<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class FootballQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpar perguntas existentes
        Question::truncate();

        $questions = [
            [
                'question' => 'Quem marcou os dois gols do Brasil na final da Copa do Mundo de 2002?',
                'options' => ['Rivaldo', 'Ronaldo Fenômeno', 'Ronaldinho Gaúcho', 'Kaká'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual clube revelou Neymar antes da sua ida ao Barcelona?',
                'options' => ['Santos', 'Flamengo', 'Palmeiras', 'São Paulo'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Em que país aconteceu a Copa do Mundo de 2014?',
                'options' => ['África do Sul', 'Alemanha', 'Brasil', 'Rússia'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Qual seleção venceu a Eurocopa de 2016?',
                'options' => ['França', 'Espanha', 'Itália', 'Portugal'],
                'correct_answer' => '3'
            ],
            [
                'question' => 'Quantos títulos da Copa do Mundo o Brasil possui?',
                'options' => ['3', '4', '5', '6'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Qual jogador possui mais Bolas de Ouro da FIFA?',
                'options' => ['Cristiano Ronaldo', 'Lionel Messi', 'Pelé', 'Maradona'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Em que ano foi realizada a primeira Copa do Mundo?',
                'options' => ['1928', '1930', '1932', '1934'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual é o maior estádio do Brasil?',
                'options' => ['Estádio do Morumbi', 'Arena Corinthians', 'Maracanã', 'Mineirão'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Quem é considerado o "Rei do Futebol"?',
                'options' => ['Maradona', 'Pelé', 'Zico', 'Garrincha'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual seleção é conhecida como "La Roja"?',
                'options' => ['Argentina', 'Chile', 'Espanha', 'Peru'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Em que clube Pelé encerrou sua carreira?',
                'options' => ['Santos', 'New York Cosmos', 'Flamengo', 'São Paulo'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual jogador marcou o gol mais rápido em Copas do Mundo?',
                'options' => ['Hakan Şükür', 'Clint Dempsey', 'Tim Cahill', 'Robbie Keane'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Quantos jogadores compõem uma equipe de futebol em campo?',
                'options' => ['10', '11', '12', '9'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual país sediou a Copa do Mundo de 2018?',
                'options' => ['Brasil', 'Rússia', 'Alemanha', 'França'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Quem é o maior artilheiro da história da Champions League?',
                'options' => ['Lionel Messi', 'Cristiano Ronaldo', 'Raúl', 'Karim Benzema'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual clube tem mais títulos da Champions League?',
                'options' => ['AC Milan', 'Barcelona', 'Real Madrid', 'Bayern Munich'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Em que ano o Brasil conquistou seu primeiro título mundial?',
                'options' => ['1950', '1958', '1962', '1970'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual jogador brasileiro marcou mais gols em Copas do Mundo?',
                'options' => ['Pelé', 'Ronaldo', 'Romário', 'Bebeto'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual é a duração oficial de uma partida de futebol?',
                'options' => ['80 minutos', '90 minutos', '100 minutos', '120 minutos'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Que país organizou a primeira Copa do Mundo?',
                'options' => ['Brasil', 'Inglaterra', 'Uruguai', 'Argentina'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Qual jogador é conhecido como "El Fenómeno"?',
                'options' => ['Ronaldinho', 'Ronaldo Nazário', 'Cristiano Ronaldo', 'Kaká'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Quantos times participam da Copa do Mundo atualmente?',
                'options' => ['24', '32', '48', '16'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual seleção tem mais títulos de Copa do Mundo?',
                'options' => ['Alemanha', 'Argentina', 'Brasil', 'Itália'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Em que cidade fica o estádio Wembley?',
                'options' => ['Manchester', 'Liverpool', 'Londres', 'Birmingham'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Qual jogador marcou o "Gol do Século" em 1986?',
                'options' => ['Pelé', 'Diego Maradona', 'Zico', 'Michel Platini'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual é o apelido da seleção brasileira?',
                'options' => ['Seleção', 'Canarinho', 'Verde-Amarela', 'Todas as anteriores'],
                'correct_answer' => '3'
            ],
            [
                'question' => 'Quem foi o primeiro jogador a marcar 1000 gols oficiais?',
                'options' => ['Maradona', 'Pelé', 'Puskas', 'Di Stéfano'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual clube Messi defendeu por mais tempo?',
                'options' => ['PSG', 'Barcelona', 'Inter Miami', 'Newell\'s Old Boys'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Em que ano foi criada a FIFA?',
                'options' => ['1900', '1904', '1908', '1912'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual país venceu a primeira Copa do Mundo?',
                'options' => ['Brasil', 'Argentina', 'Uruguai', 'Itália'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Quantos cartões vermelhos resultam em expulsão?',
                'options' => ['1', '2', '3', 'Depende da falta'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Qual é a distância oficial do pênalti?',
                'options' => ['10 metros', '11 metros', '12 metros', '13 metros'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Quem inventou o futebol moderno?',
                'options' => ['Brasileiros', 'Argentinos', 'Ingleses', 'Uruguaios'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Qual seleção é chamada de "Les Bleus"?',
                'options' => ['Itália', 'França', 'Bélgica', 'Holanda'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Em que posição joga tradicionalmente o camisa 10?',
                'options' => ['Goleiro', 'Zagueiro', 'Meio-campista', 'Atacante'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Qual clube tem o apelido "Merengues"?',
                'options' => ['Barcelona', 'Real Madrid', 'Atletico Madrid', 'Valencia'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Quem foi o primeiro brasileiro a ganhar a Bola de Ouro?',
                'options' => ['Pelé', 'Kaká', 'Ronaldinho', 'Rivaldo'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual é o maior clássico do futebol argentino?',
                'options' => ['River x Racing', 'Boca x River', 'Independiente x San Lorenzo', 'Estudiantes x Gimnasia'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Em que continente fica a sede da FIFA?',
                'options' => ['América', 'Europa', 'Ásia', 'África'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Qual jogador é conhecido como "CR7"?',
                'options' => ['Cristiano Ronaldo', 'Carlos Ronaldo', 'Clarence Ronald', 'Christian Ronaldinho'],
                'correct_answer' => '0'
            ]
        ];

        foreach ($questions as $questionData) {
            Question::create($questionData);
        }

        $this->command->info('40 perguntas de futebol criadas com sucesso!');
    }
}
