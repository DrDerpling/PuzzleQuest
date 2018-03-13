<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    public function game()
    {
        if (session()->has('name') && $this->game->isPhaseCompleted()) {
            return redirect()->route('phase-final');
        } elseif (session()->has('name') && $this->game->userSolvedPhase(session('name'))) {
            return redirect()->route('status');
        }
        if ($this->game->currentPhase === 1) {
            return view('welcome', ['game' => $this->game]);
        } elseif ($this->game->currentPhase === 2 || $this->game->currentPhase === 3) {
            return view('question', ['game' => $this->game]);
        } elseif ($this->game->currentPhase === 4) {
            return view('solved-quest', ['game' => $this->game]);
        }
    }

    public function status()
    {
        if ($this->game->currentPhase === 4) {
            return redirect()->home();
        }
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
        if ($this->game->currentPhase === 4) {
            return redirect()->home();
        }
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
        if ($this->game->currentPhase === 4) {
            return redirect()->home();
        }
        if (session()->has('name') && $this->game->isPhaseCompleted()) {
            $this->game->checkFinalAnswer(strtolower($request->input('answer')), session('name'));
            return redirect()->home();
        }
        if ($this->game->currentPhase === 1 && $this->game->checkAnswer($request->input('answer'))) {
            $name = $this->game->getName($request->input('answer'));
            session()->put('name', $name);
            $this->game->setSolved($name);
        } elseif ($this->game->currentPhase === 2 &&
            $this->game->checkAnswer(
                $request->input('answer'),
                $this->game->currentPhase,
                session('name')
            )
        ) {
            $this->game->setSolved(session('name'));
            session()->put('lastName', $this->game->getPlayers()[session('name')]['lastName']);
        } elseif ($this->game->currentPhase === 3 &&
            $this->game->checkAnswer(
                $request->input('answer'),
                $this->game->currentPhase,
                session('name')
            )) {
            $this->game->setSolved(session('name'));
        }

        return redirect()->home();
    }

    public function solveAll()
    {
        $this->game->solveAll();
        Cache::forever('game', $this->game);
    }
}
