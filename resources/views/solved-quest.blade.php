@extends('master')

@section('content')
    <div style="text-align: center; top: 40%;" class="center-input">
        <h5>Op 24 maart om 13:40 verwacht Frankenstein jullie bij Grote Voort 5 in Zwolle </h5>
        <div style="width: 100%; text-align: center">
            <a class="button btn" href="https://www.akaescaperooms.nl/">Aka Escape rooms</a>
        </div>
    </div>
@endsection()

@section('phase')
    @include('info', ['game' => $game, 'hint' => 'mail dlindeboom@intothesource.com'])
@endsection