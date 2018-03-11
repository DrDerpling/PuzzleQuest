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
                {{ ucfirst(session('name')) }}
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
</div>