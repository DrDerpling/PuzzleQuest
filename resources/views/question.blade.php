@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="message-box">

            </div>
        </div>
        @php
            $question = $game->getQuestion(session('name'));
        @endphp
        @if(array_has($question, 'operator'))
            <a href="{{$question['link']}}">
                <div class="row">
                    <div style="text-align: center" class="col m12 s12">
                        <h4>Jouw puzzle</h4>
                    </div>
                </div>
            </a>
            <form method="post" action="{{ route('verify') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col s3 m3 l3">
                        <div class="input-field">
                            <input class="validate {{$errors->has('answer.0') ? 'validate invalid' : ''}} "
                                   name="answer"
                                   id="answer" type="text">
                            <label for="answer"> {{ $question['operator'] === '-' ? 'Oplossing (som)' : 'Oplossing (bestand)' }}</label>
                        </div>
                    </div>
                    <div class="col s1 m1 l1 input-field operator">
                        {{ $question['operator'] }}
                    </div>
                    <div class="col s2 m2 l2">
                        <div class="input-field">
                            <input class="validate {{$errors->has('answer.1') ? 'validate invalid' : ''}} "
                                   name="answer"
                                   id="answer" type="text">
                            <label for="answer"> {{ 'Bestandnaam' }}</label>
                        </div>
                    </div>
                    <div class="col s1 m1 input-field operator">
                        <div>=</div>
                    </div>
                    <div class="col s3 m3 l3">
                        <div class="input-field">
                            <input class="validate {{$errors->has('answer.2') ? 'validate invalid' : ''}} "
                                   name="answer"
                                   id="answer" type="text">
                            <label for="answer"> {{ $question['operator'] === '-' ? 'Oplossing (bestand)' : 'Oplossing (som)' }}</label>
                        </div>
                    </div>
                    <div class="input-field col s2 m2 l2">
                        <button class="btn waves-effect waves-light mybtn" type="submit" name="action">Send
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        @elseif($game->currentPhase === 2)
            <form method="post" action="{{ route('verify') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col s8 m8">
                        <div class="input-field">
                            <input class="validate {{$errors->has('answer') ? 'validate invalid' : ''}} "
                                   name="answer"
                                   id="answer" type="text">
                            <label for="answer"> {{ $question['question'] }}</label>
                        </div>
                    </div>
                    <div class="input-field col s4 m4">
                        <button class="btn waves-effect waves-light mybtn" type="submit" name="action">Send
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
    @endif

@endsection()
@section('phase')
    @include('info', ['game' => $game])
@endsection