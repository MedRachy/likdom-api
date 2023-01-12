@extends('layouts.admin')
@section('content')
    <!-- Modal start date -->
    <div class="modal fade" id="ModalStartDate" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Modifier la date du début</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.abonmt.update', $sub->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_start_date">
                        <div class="mb-3 row m-auto">
                            <label for="date_debut" class="col-sm-4 col-form-label text-end">Date début</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="date_debut" name="start_date"
                                    value="{{ $sub->start_date }}">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal status -->
    <div class="modal fade" id="ModalStatut" tabindex="-1" aria-labelledby="ModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel2">Modifier la statut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.abonmt.update', $sub->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_status">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                value="valid">
                            <label class="form-check-label" for="exampleRadios1">
                                Valider
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                value="pending">
                            <label class="form-check-label" for="exampleRadios2">
                                En attente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios3"
                                value="cancel">
                            <label class="form-check-label" for="exampleRadios3">
                                Annuler
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios4"
                                value="concluded">
                            <label class="form-check-label" for="exampleRadios4">
                                Terminer
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Supprimer -->
    <div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="ModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel3">Supprimer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="lead text-danger">ête vous sur de vouloir supprimer cette abonnement</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('admin.abonmt.destroy', $sub->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal passages -->
    <div class="modal fade" id="ModalPackPassages" tabindex="-1" aria-labelledby="ModalLabel4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel4">Modifier les passages</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.abonmt.update', $sub->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_passages">

                        <div class="mb-3 row m-auto">

                            <div class="col-sm-6 mx-auto">
                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Lundi"
                                            name="day[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Lundi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Lundi"
                                        aria-label="Text input with checkbox">
                                </div>


                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Mardi"
                                            name="day[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Mardi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Mardi"
                                        aria-label="Text input with checkbox">
                                </div>


                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Mercredi"
                                            name="day[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Mercredi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Mercredi"
                                        aria-label="Text input with checkbox">
                                </div>


                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Jeudi"
                                            name="day[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Jeudi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Jeudi"
                                        aria-label="Text input with checkbox">
                                </div>

                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Vendredi"
                                            name="day[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Vendredi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Vendredi"
                                        aria-label="Text input with checkbox">
                                </div>

                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Samedi"
                                            name="day[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Samedi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Samedi"
                                        aria-label="Text input with checkbox">
                                </div>

                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Dimanche"
                                            name="day[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Dimanche</span>
                                    </div>
                                    <input type="time" class="form-control" name="Dimanche"
                                        aria-label="Text input with checkbox">
                                </div>
                            </div>

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Abonnements</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.abonmt.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">abonnement</li>
            </ol>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Abonnement
                    @switch($sub->status)
                        @case('valid')
                            <span class="badge bg-success">Valider</span>
                        @break

                        @case('pending')
                            <span class="badge bg-warning">En attente</span>
                        @break

                        @case('cancel')
                            <span class="badge bg-danger">Annuler</span>
                        @break

                        @case('concluded')
                            <span class="badge bg-secondary">Terminer</span>
                        @break

                        @default
                    @endswitch
                    <button type="button" class="float-end btn btn-sm  btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#ModalDelete">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    <button type="button" class="float-end btn btn-sm  btn-outline-dark mx-2" data-bs-toggle="modal"
                        data-bs-target="#ModalStatut">
                        Statut <i class="far fa-edit"></i>
                    </button>

                </h5>
                <div class="card-body">

                    @if ($sub->confirmed)
                        <h6 class="card-title "> Abonnement confirmer </h6>
                    @else
                        <h6 class="card-title bg-danger p-2" style="color: white"> Abonnement pas encore confirmer par le
                            client</h6>
                    @endif
                    <h6 class="card-title "> Durée d'engagement : {{ $sub->nbr_months }} mois </h6>
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between active ">
                            <div>
                                <h5 class="text-bold">Offre</h5>
                                @isset($sub->offer)
                                    <p class="mb-1">{{ $sub->offer->name }}</p>
                                @endisset

                            </div>
                            <div>
                                <h5 class="text-bold d-inline ">Date début</h5>
                                <button type="button" class="d-inline btn btn-sm  btn-outline-light"
                                    data-bs-toggle="modal" data-bs-target="#ModalStartDate">
                                    <i class="far fa-edit"></i>
                                </button>
                                <p class="mb-1">{{ $sub->start_date }}</p>
                                {{-- <p class="mb-1">Date fin :{{ $sub->abonnement->date_fin }}</p> --}}
                            </div>
                            <div>
                                <h5 class="text-bold">Prix</h5>
                                <p class="mb-1">{{ $sub->price }} DH</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold d-inline">Passages</h5>
                                <button type="button" class="d-inline btn btn-sm  btn-outline-dark"
                                    data-bs-toggle="modal" data-bs-target="#ModalPackPassages">
                                    <i class="far fa-edit"></i>
                                </button>
                                <ul>
                                    @isset($sub->passages)
                                        @foreach ($sub->passages as $passage)
                                            <li>{{ $passage['day'] }} : {{ $passage['time'] }}</li>
                                        @endforeach
                                    @endisset

                                </ul>
                            </div>
                            <div>
                                <h5 class="text-bold">Date Fin</h5>
                                <p class="mb-1 text-center">{{ $sub->end_date }}</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Nbr heures</h5>
                                <p class="mb-1 text-center">{{ $sub->nbr_hours }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Nbr employees</h5>
                                <p class="mb-1 text-center">{{ $sub->nbr_employees }}</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Adresse</h5>
                                <p class="mb-1 text-center">{{ $sub->adress }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Ville</h5>
                                <p class="mb-1 text-center">{{ $sub->city }}</p>
                            </div>
                        </li>
                        @isset($sub->location)
                            <li class="list-group-item">
                                <div id="map" class="w-100" style="height:250px"></div>
                            </li>
                        @endisset

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card  shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Client </h5>
                <div class="card-body">
                    @isset($sub->user)
                        <h6 class="card-title">

                            Utilisateur inscrit ID : {{ $sub->user_id }}
                            <a href="{{ route('admin.users.show', $sub->user_id) }}" class="edit btn btn-primary btn-sm"
                                target="_blank"><i class="fas fa-eye"></i></a>

                        </h6>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div>
                                    <h5 class="text-bold">Nom et Prénom</h5>

                                    <p class="mb-1">{{ $sub->user->name }} </p>

                                </div>
                            </li>
                            <li class="list-group-item">
                                <div>
                                    <h5 class="text-bold">Téléphone</h5>

                                    <p class="mb-1">{{ $sub->user->phone }}</p>

                                </div>
                            </li>
                            <li class="list-group-item">
                                <div>
                                    <h5 class="text-bold">Email</h5>
                                    <p class="mb-1">{{ $sub->user->email }}</p>
                                </div>
                            </li>
                            @isset($sub->offer)
                                <li class="list-group-item">
                                    <div>
                                        <h5 class="text-bold">{{ $sub->offer->name }}</h5>
                                        <p class="mb-1">{{ $sub->offer->description }}</p>
                                    </div>
                                </li>
                            @endisset
                        </ul>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card  shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Employées planifier
                    <a class="float-end btn btn-primary btn-sm text-decoration-none"
                        href="{{ route('admin.abonmt.edit', $sub->id) }}">Ajouter / Retirer</a>
                </h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Tel</th>
                                    <th scope="col">Planing</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub->employees as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</a> </td>
                                        <td>{{ $employee->last_name }}</td>
                                        <td>{{ $employee->first_name }}</td>
                                        <td>{{ $employee->adress }}</td>
                                        <td>{{ $employee->city }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.emply.show', $employee->id) }}" target="_blank"
                                                class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if ($sub->emplyHistory()->exists())
        <div class="row my-4">
            <div class="col-md-12">
                <div class="card  shadow-sm p-3  bg-white rounded">
                    <h5 class="card-header">Historique des employées déja planifier </h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Ref</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prenom</th>
                                        <th scope="col">Adresse</th>
                                        <th scope="col">Ville</th>
                                        <th scope="col">Tel</th>
                                        <th scope="col">Planing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sub->emplyHistory as $employee)
                                        <tr>
                                            <td>{{ $employee->id }}</a> </td>
                                            <td>{{ $employee->last_name }}</td>
                                            <td>{{ $employee->first_name }}</td>
                                            <td>{{ $employee->adress }}</td>
                                            <td>{{ $employee->city }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.emply.show', $employee->id) }}" target="_blank"
                                                    class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@isset($sub->location)
    @push('script')
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPTjmXMMIoio28rRoFtbd4cJ_usttf4cc&region=MA&language=fr">
        </script>

        <script>
            let map;
            let marker;
            // const LatLng = {
            //     lat: 33.687381,
            //     lng: -7.3784308
            // };
            const LatLng = @json($sub->location);
            // console.log(LatLng);
            // init map
            map = new google.maps.Map(document.getElementById("map"), {
                center: LatLng,
                zoom: 18,
                gestureHandling: "greedy",
                disableDefaultUI: true,
            });
            // location marker
            marker = new google.maps.Marker({
                position: LatLng,
                map: map,
                draggable: false,
            });
        </script>
    @endpush
@endisset
