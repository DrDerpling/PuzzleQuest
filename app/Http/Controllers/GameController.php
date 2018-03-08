<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    public function game()
    {
        if (!Cache::has('game')) {
            Cache::forever('game', $this->gameLogicStarter());
        }
        $logicArray = Cache::get('game');

        dd($logicArray);

        return view('welcome.blade');
    }

    public function verify(Request $request)
    {
        $this->validate($request,
            ['answer' => 'required']
        );
        if (!Cache::has('game')) {
            Cache::forever('game', $this->gameLogicStarter());
        }
        $logicArray = Cache::get('game', $this->gameLogicStarter());

        if ($logicArray['currentPhase'] === 1 &&
            $this->checkPhaseOneAnwsers(1, $request->input('answer')) !== false
        ) {
            $this->checkPhaseOneAnwsers(1, $request->input('answer'));
        }

        return redirect()->back();;
    }


    private function gameLogicStarter()
    {
        return [
            'currentPhase' => 1,
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
    }

    private function checkPhaseOneAnwsers($phase, $answer){
        $logicArray = Cache::get('game', $this->gameLogicStarter());

        foreach ($logicArray['phases'][$phase]['players'] as $name => $player) {
            if(in_array($answer, $player['answers'])) {
                return $name;
                break;
            }
        }
        return false;
    }
}