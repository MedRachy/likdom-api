@extends('layouts.admin')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    @endpush
    <!-- Modal Supprimer -->
    <div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="ModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel3">Supprimer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="lead text-danger">ête vous sur de vouloir supprimer cette employée</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('admin.emply.destroy', $employee->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Employées</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.emply.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">employée</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <div class="row g-0">
                    <div class="col-md-4 m-auto">
                        @isset($employee->image_path)
                            <img src="{{ asset('/storage/Emplys/' . $employee->image_path) }}" class="img-fluid rounded-start"
                                alt="..." width="400px">
                        @else
                            <img src="{{ asset('/storage/Emplys/default.jpg') }}" class="img-fluid rounded-start" alt="..."
                                width="400px">
                        @endisset

                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $employee->full_name }}
                                <button type="button" class="float-end btn btn-sm  btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#ModalDelete">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <a href="{{ route('admin.emply.edit', $employee->id) }}"
                                    class="float-end btn btn-sm  btn-outline-dark mx-2">
                                    <i class="far fa-edit"></i></a>
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Date naissance : {{ $employee->date_birth }}</li>
                                <li class="list-group-item">Téléphone : {{ $employee->phone }}</li>
                                <li class="list-group-item">Adresse : {{ $employee->adress }}</li>
                                <li class="list-group-item">Ville : {{ $employee->city }}</li>
                                <li class="list-group-item">Specialité : {{ $employee->speciality }}</li>
                            </ul>
                            <p class="card-text"><small class="text-muted">{{ $employee->availability }}</small></p>
                            <a href="{{ route('admin.emply.history', $employee->id) }}">Voire l'historique de toute les
                                réservations attribué</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card border-info shadow-sm p-3 bg-white rounded">
                <h5 class="card-header">Planing</h5>
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-info shadow-sm p-3 bg-white rounded">
                <h5 class="card-header">Réservations attribué</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($employee->subscriptions)
                                    @foreach ($employee->subscriptions as $reserv)
                                        @if ($reserv->just_once)
                                            <tr>
                                                <th scope="row">{{ $reserv->id }}</th>
                                                <td>{{ $reserv->service }}</td>
                                                <td>{{ $reserv->city }}</td>
                                                <td>{{ $reserv->adress }}</td>
                                                <td>{{ $reserv->start_date }}</td>
                                                <td>{{ $reserv->start_time }}</td>
                                                <td>{{ $reserv->price }}</td>
                                                <td>
                                                    <a href="{{ route('admin.reserv.show', $reserv->id) }}"
                                                        class="edit btn btn-primary btn-sm" target="_blank"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="{{ route('admin.reserv.edit', $reserv->id) }}"
                                                        class="edit btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endisset

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-info shadow-sm p-3 bg-white rounded">
                <h5 class="card-header">Abonnements attribué</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Offre</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Date début</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($employee->subscriptions)
                                    @foreach ($employee->subscriptions as $reserv)
                                        @if (!$reserv->just_once)
                                            <tr>
                                                <th scope="row">{{ $reserv->id }}</th>
                                                <td>{{ $reserv->offer->name }}</td>
                                                <td>{{ $reserv->city }}</td>
                                                <td>{{ $reserv->adress }}</td>
                                                <td>{{ $reserv->start_date }}</td>
                                                <td>{{ $reserv->price }}</td>
                                                <td>
                                                    <a href="{{ route('admin.abonmt.show', $reserv->id) }}"
                                                        class="edit btn btn-primary btn-sm" target="_blank"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="{{ route('admin.abonmt.edit', $reserv->id) }}"
                                                        class="edit btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endisset

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('script')
        <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js">
        </script>
        <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/fr.js">
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var events = @json($events);
                // console.log(passages);
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'fr',
                    firstDay: 1,
                    events: events,
                    eventDisplay: 'block',
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                    },
                    eventBackgroundColor: '#378006',
                    eventClick: function(info) {
                        info.jsEvent.preventDefault(); // don't let the browser navigate
                        if (info.event.url) {
                            window.open(info.event.url);
                        }
                    },
                    buttonText: {
                        today: "Aujourd'hui"
                    },
                    contentHeight: 600,
                });
                calendar.render();
            });
        </script>
    @endpush
@endsection
