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
                    ],
                ],
                2 => [
                    'players' => [
                        'esther' => [
                            'questions' => [
                                1 => [
                                    'question' => 'Oplosing + bestandnaam =',
                                    'answers' => [
                                        '15 22 5 18 11 12 5 5 6 20',
                                        '1522518111255620',
                                        '15.22.5.18.11.12.5.5.6.20'
                                    ],
                                    'link' => 'https://drive.google.com/open?id=19AYeQoyuM9lGq-zhxHelchFvhmNDXMQX',
                                    'addNum' => 1001,
                                    'solved' => false
                                ],
                                2 => [
                                    'solved' => false
                                ]
                            ]
                        ],
                        'vivian' => [
                            'questions' => [
                                1 => [
                                    'question' => 'Oplosing + bestandnaam =',
                                    'answers' => ['18 5 9 19 20 13 1', '18591920131', '18.5.9.19.20.13.1'],
                                    'link' => 'https://drive.google.com/file/d/1juvBFC6UffgzSFgSyC3teJSXvwWE0To9/view?usp=sharing',
                                    'addNum' => 2002,
                                    'solved' => false
                                ],
                                2 => [
                                    'solved' => false
                                ]
                            ]
                        ],
                        'wilfred' => [
                            'questions' => [
                                1 => [
                                    'question' => 'Oplosing + bestandnaam =',
                                    'answers' => ['815752151513', '8 15 7 5 2 15 15 13', '8.15.7.5.2.15.15.13'],
                                    'link' => 'https://drive.google.com/open?id=13aBGuAxWLUsMe2GkdicR38_Xd7IaeXxP',
                                    'addNum' => 3003,
                                    'solved' => false,
                                ],
                                2 => [
                                    'solved' => false
                                ]
                            ]
                        ],
                        'jordy' => [
                            'questions' => [
                                1 => [
                                    'question' => 'Oplosing + bestandnaam =',
                                    'answers' => ['131551907514', '13 15 5 19 11 5 18', '13.15.5.19.11.5.18'],
                                    'link' => 'https://drive.google.com/open?id=11V50MuhGjYJCWhm-gzB8dr6gq7Plla5v',
                                    'addNum' => 4004,
                                    'solved' => false
                                ],
                                2 => [
                                    'solved' => false
                                ]
                            ]
                        ]
                    ],
                    'final' => [
                        'answers' => ['4.5.14.14.9.19', '451414919'],
                        'solved' => false
                    ],
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
        if ($this->currentPhase === 1) {
            return $this->phase['players'][$name]['solved'];
        } elseif ($this->currentPhase) {
            dd($this->phase['players'][$name]['questions'][1]['solved'] && );
            return ($this->phase['players'][$name]['questions'][1]['solved'] && $this->phase['players'][$name]['questions'][2]['solved']);
        }
    }

    public function checkAnswer($answer, $phase = null, $name = null)
    {
        if (!$phase) {
            $phase = $this->currentPhase;
        }
        if ($name === null) {
            return in_array($answer, $this->getAnswers($phase));
        }

        if ($phase === 1) {
            return in_array($answer, $this->getAnswers($phase, $name));
        } elseif ($phase === 2) {
            $question = $this->getQuestion($name);
            return in_array($answer, $question['answers']);
        }
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
        if ($this->currentPhase === 1) {
            $this->phase['players'][$name]['solved'] = true;
        } elseif ($this->currentPhase === 2) {
            foreach ($this->phase['players'][$name]['questions'] as $index => $question) {
                if (!$question['solved']) {
                    $this->phase['players'][$name]['questions'][$index]['solved'] = true;
                    break;
                }
            }
        }
        Cache::forever('game', $this);
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
        if ($this->currentPhase === 1) {
            foreach ($this->phase['players'] as $name => $player) {
                if (!$player['solved']) {
                    return false;
                }
            }
        } elseif ($this->currentPhase === 2) {
            foreach ($this->phase['players'] as $name => $player) {
                foreach ($player['questions'] as $question) {
                    if (!$question['solved']) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function getQuestion($name)
    {
        foreach ($this->phase['players'][$name]['questions'] as $question) {
            if (!$question['solved']) {
                return $question;
            }
        }
        return false;
    }
}
