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
                        @if ($reserv->pack)
                            <div class="mb-3 row m-auto">
                                <label for="date_debut" class="col-sm-4 col-form-label text-end">Date début</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="date_debut" name="date_debut"
                                        value="{{ $reserv->date_debut }}">
                                </div>
                            </div>
                        @else
                            <div class="mb-3 row m-auto">
                                <label for="date_passage" class="col-sm-4 col-form-label text-end">Date</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="date_passage" name="date_passage"
                                        value="{{ $reserv->date_passage }}">
                                </div>
                            </div>
                            <div class="mb-3 row m-auto">
                                <label for="heure_passage" class="col-sm-4 col-form-label text-end">Heure</label>
                                <div class="col-sm-6">
                                    <input type="time" class="form-control" id="heure_passage" name="heure_passage"
                                        value="{{ $reserv->heure_passage }}">
                                </div>
                            </div>
                        @endif


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal statut -->
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
                        <input type="hidden" name="edit_statut">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statut" id="exampleRadios1"
                                value="valider">
                            <label class="form-check-label" for="exampleRadios1">
                                Valider
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statut" id="exampleRadios2"
                                value="en_attente">
                            <label class="form-check-label" for="exampleRadios2">
                                En attente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statut" id="exampleRadios3"
                                value="annuler">
                            <label class="form-check-label" for="exampleRadios3">
                                Annuler
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statut" id="exampleRadios4"
                                value="terminer">
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
    <!-- Modal pack passages -->
    <div class="modal fade" id="ModalPackPassages" tabindex="-1" aria-labelledby="ModalLabel4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel4">Modifier les passages</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.reserv.update', $reserv->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_pack_passages">

                        <div class="mb-3 row m-auto">

                            <div class="col-sm-6 mx-auto">
                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Lundi"
                                            name="jour[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Lundi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Lundi"
                                        aria-label="Text input with checkbox">
                                </div>


                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Mardi"
                                            name="jour[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Mardi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Mardi"
                                        aria-label="Text input with checkbox">
                                </div>


                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Mercredi"
                                            name="jour[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Mercredi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Mercredi"
                                        aria-label="Text input with checkbox">
                                </div>


                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Jeudi"
                                            name="jour[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Jeudi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Jeudi"
                                        aria-label="Text input with checkbox">
                                </div>

                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Vendredi"
                                            name="jour[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Vendredi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Vendredi"
                                        aria-label="Text input with checkbox">
                                </div>

                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Samedi"
                                            name="jour[]" aria-label="Checkbox for following text input">
                                        <span class="mx-1">Samedi</span>
                                    </div>
                                    <input type="time" class="form-control" name="Samedi"
                                        aria-label="Text input with checkbox">
                                </div>

                                <div class="input-group mt-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 " type="checkbox" value="Dimanche"
                                            name="jour[]" aria-label="Checkbox for following text input">
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
                    @switch($reserv->statut)
                        @case('valider')
                            <span class="badge bg-success">Valider</span>
                        @break

                        @case('en_attente')
                            <span class="badge bg-warning">En attente</span>
                        @break

                        @case('annuler')
                            <span class="badge bg-danger">Annuler</span>
                        @break

                        @case('terminer')
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
                        @isset($reserv->pack)
                            <li class="list-group-item d-flex justify-content-between active ">
                                <div>
                                    <h5 class="text-bold">Pack</h5>
                                    <p class="mb-1">{{ $reserv->pack->name }}</p>
                                </div>
                                <div>
                                    <h5 class="text-bold d-inline ">Date début</h5>
                                    <button type="button" class="d-inline btn btn-sm  btn-outline-light"
                                        data-bs-toggle="modal" data-bs-target="#ModalPassage">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <p class="mb-1">{{ $reserv->date_debut }}</p>
                                    {{-- <p class="mb-1">Date fin :{{ $reserv->abonnement->date_fin }}</p> --}}
                                </div>
                                <div>
                                    <h5 class="text-bold">Prix</h5>
                                    <p class="mb-1">{{ $reserv->prix }} DH</p>
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
                                        @foreach ($reserv->passages as $passage)
                                            <li>{{ $passage['jour'] }} : {{ $passage['heure'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div>
                                    <h5 class="text-bold">Passages par semaine</h5>
                                    <p class="mb-1 text-center">{{ $reserv->pack->nbr_passages }}</p>
                                </div>
                            </li>
                        @else
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
                                    <p class="mb-1">Date : {{ $reserv->date_passage }}</p>
                                    <p class="mb-1">Heure :{{ $reserv->heure_passage }}</p>
                                </div>
                                <div>
                                    <h5 class="text-bold">Prix</h5>
                                    <p class="mb-1">{{ $reserv->prix }} DH</p>
                                </div>
                            </li>
                        @endisset


                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Adresse</h5>
                                <p class="mb-1">{{ $reserv->adresse }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Ville</h5>
                                <p class="mb-1">{{ $reserv->ville }}</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            @if (in_array($reserv->service, ['menage_simple', 'grand_menage']))
                                <div>
                                    <h5 class="text-bold">Pieces</h5>
                                    <ul>
                                        <li>Chambre : {{ $reserv->pieces['chambre'] }}</li>
                                        <li>Cuisine : {{ $reserv->pieces['cuisine'] }}</li>
                                        <li>Toilette : {{ $reserv->pieces['toilette'] }}</li>
                                        <li>Salon Trad : {{ $reserv->pieces['salon_traditionnel'] }}</li>
                                        <li>Salon Modern : {{ $reserv->pieces['salon_moderne'] }}</li>
                                    </ul>
                                </div>
                                <div>
                                    <ul>
                                        <li>Sejour : {{ $reserv->pieces['sejour'] }}</li>
                                        <li>Coure : {{ $reserv->pieces['coure'] }}</li>
                                        <li>Terasse : {{ $reserv->pieces['terasse'] }}</li>
                                        <li>Buanderie : {{ $reserv->pieces['buanderie'] }}</li>
                                        <li>Garage : {{ $reserv->pieces['garage'] }}</li>
                                        <li>Niveau : {{ $reserv->pieces['niveau'] }}</li>
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <h5 class="text-bold">Type logement</h5>
                                <p class="mb-1 text-center">{{ $reserv->type_logement }}</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Nettoyants selectionné</h5>
                                <ul>
                                    @isset($reserv->type_surface)
                                        @foreach ($reserv->type_surface as $produit)
                                            <li>{{ $produit }}</li>
                                        @endforeach
                                    @else
                                        <li>Aucun produits choisis</li>
                                    @endisset

                                </ul>
                            </div>
                            <div>
                                <h5 class="text-bold">Equipements selectionné</h5>
                                <ul>
                                    @isset($reserv->equipements)
                                        @foreach ($reserv->equipements as $equip)
                                            <li>{{ $equip }}</li>
                                        @endforeach
                                    @else
                                        <li>Aucun Equipements choisis</li>
                                    @endisset

                                </ul>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Tâches</h5>
                                <ul>
                                    @isset($reserv->taches)
                                        @foreach ($reserv->taches as $tache)
                                            <li>{{ $tache }}</li>
                                        @endforeach
                                    @else
                                        <li>[Tâches propre au service choisi]</li>
                                    @endisset
                                </ul>
                            </div>
                        </li>
                        @isset($reserv->ameublements)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h5 class="text-bold">Ameublements</h5>
                                    @include('admin.components.nettoyage_sec')
                                </div>
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
                    @isset($reserv->user)
                        <h6 class="card-title">

                            Utilisateur inscrit ID : {{ $reserv->user->id }}
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
                            @isset($reserv->pack)
                                <li class="list-group-item">
                                    <div>
                                        <h5 class="text-bold">Pack</h5>
                                        <p class="mb-1">{{ $reserv->pack->name }}</p>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div>
                                        <h5 class="text-bold">---</h5>
                                        <p class="mb-1">{{ $reserv->pack->description }}</p>
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
                                    <th scope="col">Age</th>
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
                                        <td>{{ $employee->nom }}</td>
                                        <td>{{ $employee->prenom }}</td>
                                        <td>{{ $employee->age }}</td>
                                        <td>{{ $employee->adresse }}</td>
                                        <td>{{ $employee->ville }}</td>
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
                                        <th scope="col">Age</th>
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
                                            <td>{{ $employee->nom }}</td>
                                            <td>{{ $employee->prenom }}</td>
                                            <td>{{ $employee->age }}</td>
                                            <td>{{ $employee->adresse }}</td>
                                            <td>{{ $employee->ville }}</td>
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
