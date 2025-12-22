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
                'question' => 'Which manager is most credited with pioneering modern gegenpressing?',
                'options' => ['Ralf Rangnick', 'Jürgen Klopp', 'Marcelo Bielsa', 'Arrigo Sacchi'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Starting from the group stage, how many matches must a club play to lift the UEFA Champions League trophy?',
                'options' => ['9', '12', '15', '13'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Which tactical system is characterized by a back three and wing-backs providing width?',
                'options' => ['4-3-3', '3-5-2', '4-2-3-1', '3-4-3'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Which club holds the record for most consecutive domestic league titles in top-five European leagues?',
                'options' => ['Bayern Munich', 'Juventus', 'Real Madrid', 'Celtic'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Who scored the fastest goal in UEFA Champions League history?',
                'options' => ['Roy Makaay', 'Gualter Fatun', 'Jan Sýkora', 'Kylian Mbappé'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which statistical metric measures a player’s expected goals contribution from passes and shots?',
                'options' => ['xG', 'xA', 'npxG', 'xGChain'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Which nation won the first FIFA World Cup to be decided by a penalty shootout in the final tournament phase?',
                'options' => ['West Germany', 'France', 'Argentina', 'Spain'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'In UEFA two-legged knockout ties, which tie-breaker was abolished across UEFA competitions in 2021?',
                'options' => ['Away goals rule', 'Extra time', 'Penalty shootout', 'Golden goal'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which goalkeeper holds the record for the most consecutive clean sheets in the English Premier League (since 1992)?',
                'options' => ['Petr Čech', 'Ederson', 'Pepe Reina', 'Ben Foster'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which club completed the highest transfer fee paid for a defender?',
                'options' => ['Manchester United', 'Liverpool', 'Manchester City', 'Paris Saint-Germain'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'What is the maximum number of substitutes a team may name on the bench in most UEFA club competitions (recent regulations)?',
                'options' => ['7', '9', '12', '15'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Which nation has produced the most Ballon d\'Or winners through 2024?',
                'options' => ['Argentina', 'Portugal', 'France', 'Spain'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which manager famously used the "tiki-taka" philosophy to win multiple major trophies?',
                'options' => ['Pep Guardiola', 'Carlo Ancelotti', 'Diego Simeone', 'Louis van Gaal'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Who holds the record for the most international goals scored in men\'s football (national teams)?',
                'options' => ['Ali Daei', 'Cristiano Ronaldo', 'Lionel Messi', 'Mokhtar Dahari'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Which club won the inaugural UEFA Europa League (rebranded from UEFA Cup) final after the rebrand in 2009?',
                'options' => ['Shakhtar Donetsk', 'Atlético Madrid', 'Porto', 'Sevilla'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which formation is usually described as two holding midfielders shielding the defence and one advanced playmaker?',
                'options' => ['4-2-3-1', '4-4-2', '3-4-3', '4-1-4-1'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which competition introduced the Video Assistant Referee (VAR) at the FIFA Club World Cup final first among FIFA tournaments?',
                'options' => ['2016', '2014', '2018', '2022'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Who is the all-time top scorer for the Brazil national team?',
                'options' => ['Pelé', 'Ronaldo Nazário', 'Neymar', 'Bebeto'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Which African nation reached the World Cup quarter-finals in 2022, setting a continental best in that tournament?',
                'options' => ['Morocco', 'Senegal', 'Cameroon', 'Tunisia'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'What tactical concept describes deliberately dropping a forward into midfield to create numerical superiority?',
                'options' => ['False nine', 'Target man', 'Poacher', 'Inverted winger'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which manager won the treble (domestic league, domestic cup, Champions League) with a single club in the 21st century?',
                'options' => ['Sir Alex Ferguson', 'Pep Guardiola', 'José Mourinho', 'Arsène Wenger'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Which rule change shortened the time teams could waste before a throw-in was taken (enforced by referees)?',
                'options' => ['6-second rule', 'Kick-off delay rule', 'Time-wasting guidance', 'Sin-bin for dissent'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Which player scored a hat-trick in a single World Cup match for Argentina in 1958?',
                'options' => ['Omar Sívori', 'Sándor Kocsis', 'Pelé', 'Mario Kempes'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which club has the record for most UEFA club competition titles combined (Champions League + Europa/UEFA Cup + Cup Winners Cup)?',
                'options' => ['AC Milan', 'Real Madrid', 'Sevilla', 'Juventus'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'What is the name of the advanced metric that values every on-ball action in the build-up to a shot?',
                'options' => ['xG', 'xGI', 'xGChain', 'xGBuildup'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Which player won the Golden Boot at the 2010 FIFA World Cup?',
                'options' => ['Thomas Müller', 'Diego Forlán', 'Wesley Sneijder', 'David Villa'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which national team is nicknamed "Azzurri"?',
                'options' => ['Italy', 'Netherlands', 'Greece', 'Sweden'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which manager is associated with the motto "parking the bus" after a famous Champions League semi-final performance?',
                'options' => ['José Mourinho', 'Carlo Ancelotti', 'Jupp Heynckes', 'Diego Simeone'],
                'correct_answer' => '3'
            ],
            [
                'question' => 'What month and year did the Premier League first permit five substitutes per match (temporary rule)?',
                'options' => ['March 2020', 'June 2020', 'August 2020', 'January 2021'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Which club completed the treble of Champions League, domestic league and domestic cup most recently?',
                'options' => ['Manchester City', 'Bayern Munich', 'Barcelona', 'Inter Milan'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which international tournament uses the fair play rule as a tie-breaker before a drawing of lots?',
                'options' => ['UEFA European Championship', 'FIFA World Cup', 'Copa América', 'African Cup of Nations'],
                'correct_answer' => '1'
            ],
            [
                'question' => 'Who is the youngest manager ever to win the UEFA Champions League (by age at win)?',
                'options' => ['Pep Guardiola', 'José Mourinho', 'Carlo Ancelotti', 'Ernesto Valverde'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which country hosted the European Championship in 2004 where a major upset saw Greece win the tournament?',
                'options' => ['Portugal', 'Greece', 'Turkey', 'Spain'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which strikers are credited with the origin of the term "false nine" popularization in modern tactics?',
                'options' => ['Lionel Messi and Francesco Totti', 'Ronaldo and Romário', 'Thierry Henry and Alan Shearer', 'Luis Suárez and Wayne Rooney'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which club has the record for the most consecutive wins in all competitions in a single season (major European clubs)?',
                'options' => ['Real Madrid', 'Manchester City', 'Bayern Munich', 'Paris Saint-Germain'],
                'correct_answer' => '2'
            ],
            [
                'question' => 'Which competition did the MLS adopt as its playoff final format name?',
                'options' => ['MLS Cup', 'Supporters\' Shield', 'US Open Cup', 'Leagues Cup'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which English club famously avoided relegation in 2005 after signing several veterans in the January window and winning survival matches?',
                'options' => ['West Ham United', 'Leicester City', 'Sunderland', 'Wigan Athletic'],
                'correct_answer' => '0'
            ],
            [
                'question' => 'Which milestone did Lionel Messi achieve at the 2022 FIFA World Cup final?',
                'options' => ['Most World Cup appearances', 'Most international goals', 'Winning the World Cup and Ballon d\'Or in same year', 'Most assists in a final'],
                'correct_answer' => '2'
            ]
        ];

        foreach ($questions as $questionData) {
            Question::create($questionData);
        }

        $this->command->info('40 football questions created successfully!');
    }
}
