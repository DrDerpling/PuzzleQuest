@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="message-box">

            </div>
        </div>
        <form method="post" action="{{ route('verify') }}">
            <div class="row">
                <div class="col s8 m8">
                    <div class="input-field">
                        <input class="validate {{$errors->has('answer') ? 'validate invalid' : ''}} " name="answer"
                               id="answer" type="text">
                        <label for="answer"> {{$game->getQuestion(session('name'))['question']}}</label>
                    </div>
                </div>
                <div class="input-field col s4 m4">
                    <button class="btn waves-effect waves-light mybtn" type="submit" name="action">Send
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>

@endsection()
@section('phase')
    @include('info', compact('game'))
@endsection