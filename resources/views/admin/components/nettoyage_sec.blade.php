@if (!empty($reserv->ameublements['canapes']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>Canapés </h6>
            @foreach ($reserv->ameublements['canapes'] as $canape)
                <li class="list-group-item list-group-flush text-start">
                    <span>{{ $canape['index'] + 1 }} *</span> &nbsp;
                    <span>Places: {{ $canape['places'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if (!empty($reserv->ameublements['fauteuils']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>Fauteuils </h6>
            @foreach ($reserv->ameublements['fauteuils'] as $fauteuil)
                <li class="list-group-item list-group-flush text-start">
                    <span>{{ $fauteuil['index'] + 1 }} *</span> &nbsp;
                    <span>Places: {{ $fauteuil['places'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if (!empty($reserv->ameublements['chaises']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>chaises </h6>
            <li class="list-group-item list-group-flush text-start">
                <span>Nombre de chaises :</span> &nbsp;
                <span>{{ $reserv->ameublements['chaises'] }}</span>
            </li>
        </ul>
    </div>
@endif
@if (!empty($reserv->ameublements['meridiennes']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>Meridiennes </h6>
            @foreach ($reserv->ameublements['meridiennes'] as $meridienne)
                <li class="list-group-item list-group-flush text-start">
                    <span>{{ $meridienne['index'] + 1 }} *</span> &nbsp;
                    <span>places: {{ $meridienne['places'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if (!empty($reserv->ameublements['canapelits']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>Canapé lit </h6>
            @foreach ($reserv->ameublements['canapelits'] as $canapelit)
                <li class="list-group-item list-group-flush text-start">
                    <span>{{ $canapelit['index'] + 1 }} *</span> &nbsp;
                    <span>places: {{ $canapelit['places'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if (!empty($reserv->ameublements['matelas']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>Matelas </h6>
            @foreach ($reserv->ameublements['matelas'] as $matela)
                <li class="list-group-item list-group-flush text-start">
                    <span>{{ $matela['index'] + 1 }} *</span> &nbsp;
                    <span>taille: {{ $matela['taille'] }}cm</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if (!empty($reserv->ameublements['tapis']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>Tapis/Moquette</h6>
            @foreach ($reserv->ameublements['tapis'] as $tapi)
                <li class="list-group-item list-group-flush text-start">
                    <span>{{ $tapi['index'] + 1 }} *</span>
                    <span>{{ $tapi['type'] }}</span>&nbsp;
                    <span>H:{{ $tapi['hauteur'] }}cm</span>&nbsp;
                    <span>L:{{ $tapi['longueur'] }}cm</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if (!empty($reserv->ameublements['rideaux']))
    <div class="col">
        <ul class="list-group list-group-flush ul-pieces">
            <h6>Rideaux</h6>
            @foreach ($reserv->ameublements['rideaux'] as $rideau)
                <li class="list-group-item list-group-flush text-start">
                    <span>{{ $rideau['index'] + 1 }} *</span>
                    <span>H:{{ $rideau['hauteur'] }}cm</span>&nbsp;
                    <span>L:{{ $rideau['longueur'] }}cm</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
