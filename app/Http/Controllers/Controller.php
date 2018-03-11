<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $game;

    public function __construct()
    {
        $this->game = Cache::rememberForever('game', function () {
            return new Game();
        });
    }
}
