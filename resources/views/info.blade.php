<div class="phase-shower">
    <div class="row">
        <div style="text-align: left" class="col s4">
            <strong>Fase</strong>:
        </div>
        <div class="col s8">
            {{ $game->isPhaseCompleted() ? "Finale" : $game->currentPhase }}
        </div>
    </div>

    @if(session()->has('name'))
        <div class="row">
            <div style="text-align: left" class="col s4">
                <strong>Speler</strong>:
            </div>
            <div class="col s8">
                {{ ucfirst(session('name')) }} {{session()->has('lastName') ? ucfirst(session('lastName')) : ''}}
            </div>
        </div>
    @endif
    @if(isset($hint))
        <div class="row">
            <div style="text-align: left" class="col s4">
                <strong>Hint</strong>:
            </div>
            <div class="col s8">
                {{ $hint }}
            </div>
        </div>
    @endif
    @php
        if (session()->has('name') && session('name') === 'wilfred') {
            $fact = 'Dennis houdt niet van tennis';
        } elseif (session()->has('name') && session('name') === 'vivian') {
            $fact = 'Tosti\'s horen minimaal ham & kaas te hebben';
        }
        $change = rand(1,10);
    @endphp
    @if(isset($fact) &&  $change === 1)
        <div class="row">
            <div style="text-align: left" class="col s4">
                <strong>Feit</strong>:
            </div>
            <div class="col s8">
                {{ $fact }}
            </div>
        </div>
    @endif
</div>