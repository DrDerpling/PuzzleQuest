@extends('master')

@section('content')
    <div class="center-input">
        <form method="post" action="{{route('login')}}">
            {{csrf_field()}}
            <div class="row" style="text-align: center"><h5>Sorry wie is dit ?</h5></div>
            <div class="row">
                <div class="input-field col s8 m8">
                    <input class="validate {{$errors->has('answer') ? 'validate invalid' : ''}} " name="answer"
                           id="answer" type="text">
                    <label for="answer">Voer uw eerste code in</label>
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
    <div class="phase-shower">
        <p>Fase: {{$game->isPhaseCompleted() ? "Finale" : $game->currentPhase}}</p>
    </div>
@endsection