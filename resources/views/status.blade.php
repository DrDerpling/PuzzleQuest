@extends('master')

@section('content')
    <div class="container">
        <div class="row m-t-100">
            @foreach($game->getPlayers() as $name => $player)
                <div class="col s3 m3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-title">{{ ucfirst($name) }} {{isset($player['lastName']) ? ucfirst($player['lastName']) : ''}}</div>
                            @if($game->userSolvedPhase($name) && $game->currentPhase === 1)
                                <p>{{$player['answers'][0]}}</p>
                                <i style="color: green" class="large material-icons">check</i>
                                <p>Opgelost</p>
                                @elseif($game->userSolvedPhase($name) && $game->currentPhase === 2)
                                <p style="font-size: 12px">{{$player['questions'][2]['question']}} {{$player['questions'][2]['answers'][0]}}</p>
                                <i style="color: green" class="large material-icons">check</i>
                                <p>Opgelost</p>
                                @elseif($game->userSolvedPhase($name) && $game->currentPhase === 3)
                                <p style="font-size: 12px">{!! $player['questions'][1]['question'] !!} <br> {!! $player['questions'][1]['answers'][0] !!}</p>
                                <i style="color: green" class="large material-icons">check</i>
                                <p>Opgelost</p>
                            @else
                                <i style="color: red" class="large material-icons">close</i>
                                <p>Onopgelost</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@section('css')
    <link type="text/css" rel="stylesheet" href="css/phase-final.css">
@endsection


@endsection()
@section('phase')
@include('info', compact('game'))
@endsection