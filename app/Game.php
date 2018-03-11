<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Game extends Model
{
    public $currentPhase;
    public $state;
    private $phase;
    private $phaseHistory = [];

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
                    ],
                    'final' => [
                        'answers' => ['4.5.14.14.9.19', '451414919'],
                        'solved' => false
                    ]
                ]
            ]
        ];
        if (isset($phaseArray['phases'][$phase])) {
            return $phaseArray['phases'][$phase];
        } else {
            return [];
        }
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

    public function checkFinalAnswer($answer, $name, $phase = null)
    {
        if (!$phase) {
            $phase = $this->currentPhase;
        }
        if ($phase === $this->currentPhase) {
            $phaseArray = $this->phase;
        } else {
            $phaseArray = $this->getPhase($phase);
        }
        if (in_array($answer, $phaseArray['final']['answers'])) {
            $phaseArray['final']['solved'] = true;
            $phaseArray['solvedBy'] = $name;
            $phaseArray['phase'] = $phase;
            $phaseArray = [$phase => $phaseArray];
            $this->phaseHistory = array_merge($phaseArray, $this->phaseHistory);
            $this->currentPhase++;
            $this->phase = $this->getPhase($this->currentPhase);
            Cache::forever('game', $this);
            return true;
        } else {
            return false;
        }
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

    public function getPlayers()
    {
        return $this->phase['players'];
    }

    public function solveAll()
    {
        foreach ($this->phase['players'] as $name => $player) {
            $this->phase['players'][$name]['solved'] = true;
        }
    }

    public function isPhaseCompleted()
    {
        foreach ($this->phase['players'] as $name => $player) {
            if (!$player['solved']) {
                return false;
            }
        }
        return true;
    }
}
