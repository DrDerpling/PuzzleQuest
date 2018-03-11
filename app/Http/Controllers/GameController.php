<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    public function game()
    {
        if (\session()->has('name') && $this->game->userSolvedPhase(session('name'))) {
            return redirect()->route('status');
        }
        return view('welcome', ['game' => $this->game]);
    }

    public function status()
    {
        if (session()->has('name') && $this->game->userSolvedPhase(session('name'))) {
            dd($this->game);
            return view('status', ['game' => $this->game()]);

        } else {
            return redirect()->home();
        }
    }

    public function verify(Request $request)
    {
        $this->validate(
            $request,
            ['answer' => 'required']
        );
        if ($this->game->currentPhase === 1 && $this->game->checkAnswer($request->input('answer'))) {
            $name = $this->game->getName($request->input('answer'));
            session()->put('name', $name);
            $this->game->setSolved($name);
            Cache::forever('game', $this->game);
        }

        return redirect()->home();
    }
}
