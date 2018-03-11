<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    public function game()
    {
        dd($this->game);
        if (session()->has('name') && $this->game->isPhaseCompleted()) {
            return redirect()->route('phase-final');
        } elseif (session()->has('name') && $this->game->userSolvedPhase(session('name'))) {
            return redirect()->route('status');
        }
        return view('welcome', ['game' => $this->game]);
    }

    public function status()
    {
        if (session()->has('name') && $this->game->isPhaseCompleted()) {
            return redirect()->route('phase-final');
        } elseif (session()->has('name') && $this->game->userSolvedPhase(session('name'))) {
            return view('status', ['game' => $this->game]);
        } else {
            return redirect()->home();
        }
    }

    public function phaseFinal()
    {
        if (session()->has('name') && $this->game->isPhaseCompleted()) {
            return view('phase-final', ['game' => $this->game]);
        } elseif (session()->has('name') && $this->game->userSolvedPhase(session('name'))) {
            return redirect()->route('status');
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
        if (session()->has('name') && $this->game->isPhaseCompleted()) {
            $this->game->checkFinalAnswer($request->input('answer'), session('name'));
        }
        if ($this->game->currentPhase === 1 && $this->game->checkAnswer($request->input('answer'))) {
            $name = $this->game->getName($request->input('answer'));
            session()->put('name', $name);
            $this->game->setSolved($name);
            Cache::forever('game', $this->game);
        }

        return redirect()->home();
    }

    public function solveAll()
    {
        $this->game->solveAll();
        Cache::forever('game', $this->game);
    }
}
