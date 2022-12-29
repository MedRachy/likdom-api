@extends('layouts.admin')
@section('content')
    <!-- Modal passage -->
    <div class="modal fade" id="ModalPassage" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Modifier le passage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.reserv.update', $reserv->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_passage">

                        <div class="mb-3 row m-auto">
                            <label for="start_date" class="col-sm-4 col-form-label text-end">Date</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ $reserv->start_date }}">
                            </div>
                        </div>
                        <div class="mb-3 row m-auto">
                            <label for="start_time" class="col-sm-4 col-form-label text-end">Heure</label>
                            <div class="col-sm-6">
                                <input type="time" class="form-control" id="start_time" name="start_time"
                                    value="{{ $reserv->start_time }}">
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
                    <form action="{{ route('admin.reserv.update', $reserv->id) }}" method="POST">
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
                    <p class="lead text-danger">ête vous sur de vouloir supprimer cette réservation</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('admin.reserv.destroy', $reserv->id) }}">
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
            <h1 class="mt-4">Réservations</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reserv.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">reservation</li>
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
                <h5 class="card-header">Réservation
                    @switch($reserv->status)
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

                    @if ($reserv->confirmed)
                        <h6 class="card-title "> Reservation confirmer </h6>
                    @else
                        <h6 class="card-title bg-danger p-2" style="color: white"> Reservation pas encore confirmer par le
                            client</h6>
                    @endif

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between active ">
                            <div>
                                <h5 class="text-bold">Service</h5>
                                <p class="mb-1">{{ $reserv->service }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold d-inline "> Passage</h5>
                                <button type="button" class="d-inline btn btn-sm  btn-outline-light"
                                    data-bs-toggle="modal" data-bs-target="#ModalPassage">
                                    <i class="far fa-edit"></i>
                                </button>
                                <p class="mb-1">Date : {{ $reserv->start_date }}</p>
                                <p class="mb-1">Heure :{{ $reserv->start_time }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Prix</h5>
                                <p class="mb-1">{{ $reserv->price }} DH</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Nbr heures</h5>
                                <p class="mb-1 text-center">{{ $reserv->nbr_hours }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Nbr employees</h5>
                                <p class="mb-1 text-center">{{ $reserv->nbr_employees }}</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Adresse</h5>
                                <p class="mb-1">{{ $reserv->adress }}</p>
                                <p><a href="">link to location</a></p>
                            </div>
                            <div>
                                <h5 class="text-bold">Ville</h5>
                                <p class="mb-1">{{ $reserv->city }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card  shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Client </h5>
                <div class="card-body">
                    @isset($reserv->user)
                        <h6 class="card-title">

                            Utilisateur inscrit ID : {{ $reserv->user_id }}
                            <a href="{{ route('admin.users.show', $reserv->user_id) }}" class="edit btn btn-primary btn-sm"
                                target="_blank"><i class="fas fa-eye"></i></a>

                        </h6>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div>
                                    <h5 class="text-bold">Nom et Prénom</h5>

                                    <p class="mb-1">{{ $reserv->user->name }} </p>

                                </div>
                            </li>
                            <li class="list-group-item">
                                <div>
                                    <h5 class="text-bold">Téléphone</h5>

                                    <p class="mb-1">{{ $reserv->user->phone }}</p>

                                </div>
                            </li>
                            <li class="list-group-item">
                                <div>
                                    <h5 class="text-bold">Email</h5>
                                    <p class="mb-1">{{ $reserv->user->email }}</p>
                                </div>
                            </li>
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
                        href="{{ route('admin.reserv.edit', $reserv->id) }}">Ajouter / Retirer</a>
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
                                @foreach ($reserv->employees as $employee)
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
    @if ($reserv->emplyHistory()->exists())
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
                                    @foreach ($reserv->emplyHistory as $employee)
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
