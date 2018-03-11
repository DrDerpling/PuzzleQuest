@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="message-box">

            </div>
        </div>
        <div class="row">
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

@endsection()
@section('phase')
@include('info', compact('game'))
@endsection