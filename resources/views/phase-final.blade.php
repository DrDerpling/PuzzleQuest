@extends('master')

@section('content')
    <div class="container">
        <div class="m-t-30 row">
            @foreach($game->getPlayers() as $name => $player)
                <div class="col s3 m3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-title">{{ ucfirst($name) }}</div>
                            @if($player['solved'])
                                <p>{{$player['answers'][0]}}</p>
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
    <div class="center-input">
        <form method="post" action="{{route('verify')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="input-field col s8 m8">
                    <input class="validate {{$errors->has('answer') ? 'validate invalid' : ''}} " name="answer"
                           id="answer" type="text">
                    <label for="answer">Voer de Finale code in om Fase {{$game->currentPhase}} te voltooien</label>
                </div>
                <div class="input-field col s4 m4">
                    <button class="btn waves-effect waves-light mybtn" type="submit" name="action">Send
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection()

@section('phase')
    @include('info', ['game' => $game, 'hint' => 'Er mist een persoon'])
@endsection