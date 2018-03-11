<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $currentPhase;
    private $phase;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->currentPhase = 1;
        $this->startPhase($this->currentPhase);
    }

    private function startPhase($phase = null)
    {
        if (!$phase) {
            $phase = $this->currentPhase;
        }

        $this->phase = $this->getPhase($phase);
    }

    private function getPhase($phase)
    {
        $phaseArray = [
            'phases' => [
                1 => [
                    'players' => [
                        'wilfred' => [
                            'answers' => ['23.9.12.6.18.5.4', '2391261854'],
                            'solved' => false
                        ],
                        'jordy' => [
                            'answers' => ['10.15.18.4.25', '101518425'],
                            'solved' => false
                        ],
                        'vivian' => [
                            'answers' => ['22.9.22.9.1.14', '229229114'],
                            'solved' => false
                        ],
                        'esther' => [
                            'answers' => ['5.19.20.8.5.18', '519208518'],
                            'solved' => false
                        ],
                        'dennis' => [
                            'answers' => ['4.5.14.14.9.19', '451414919'],
                            'solved' => false
                        ]
                    ]
                ]
            ]
        ];

        return $phaseArray['phases'][$phase];
    }

    public function userSolvedPhase($name)
    {
        return $this->phase['players'][$name]['solved'];
    }

    public function checkAnswer($answer, $phase = null, $name = null)
    {
        if (!$phase) {
            $phase = $this->currentPhase;
        }
        if ($name === null) {
            return in_array($answer, $this->getAnswers($phase));
        }

        return in_array($answer, $this->getAnswers($phase, $name));
    }

    public function getName($answers, $phase = null)
    {
        if (!$phase) {
            $phase = $this->currentPhase;
        }

        $phaseArray = $this->getPhase($phase);

        foreach ($phaseArray['players'] as $name => $player) {
            if (in_array($answers, $player['answers'])) {
                return $name;
                break;
            }
        }

        return 'MissingNo';
    }

    private function getAnswers($phase, $name = null)
    {
        $phaseArray = $this->getPhase($phase);

        if ($name && isset($phaseArray['players'][$name])) {
            return $phaseArray['players'][$name]['answers'];
        } else {
            $returnArray = [];
            foreach ($phaseArray['players'] as $name => $player) {
                $returnArray = array_merge($player['answers'], $returnArray);
            }
            return $returnArray;
        }

        return [];
    }

    public function setSolved($name)
    {
        $this->phase['players'][$name]['solved'] = true;
    }
}
