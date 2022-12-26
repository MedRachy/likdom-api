@extends('layouts.admin')
@section('content')
    <!-- Modal Supprimer -->
    <div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="ModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel3">Supprimer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="lead text-danger">ête vous sur de vouloir supprimer cette entreprise</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteform" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button id="btndelete" type="submit" class="btn btn-danger">Supprimer</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Utilisateurs</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">utilisateur</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Utilisateur</h5>
                <div class="card-body">
                    {{-- <h4><span class="badge bg-info">45 Points</span></h4> --}}
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between active ">
                            <div>
                                <h5 class="text-bold">Nom et Prénom</h5>
                                <p class="mb-1">{{ $user->name }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Email</h5>
                                <p class="mb-1">{{ $user->email }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Tel</h5>
                                <p class="mb-1">{{ $user->phone }}</p>
                            </div>

                        </li>

                        @isset($user->reservations)
                            @foreach ($user->reservations as $reserv)
                                @isset($reserv->pack)
                                    <li class="list-group-item d-flex justify-content-between list-group-item-primary">
                                        <div>
                                            <h5 class="text-bold">Ref</h5>
                                            <p class="mb-1"><a href="{{ route('admin.reserv.show', $reserv->id) }}"
                                                    target="_blank">{{ $reserv->id }}</a></p>

                                        </div>
                                        <div>
                                            <h5 class="text-bold">Pack</h5>
                                            <p class="mb-1">{{ $reserv->pack->name }}</p>

                                        </div>
                                        <div>
                                            <h5 class="text-bold">Date début</h5>
                                            <p class="mb-1">{{ $reserv->date_debut }}</p>
                                        </div>
                                        <div>
                                            <h5 class="text-bold">Passages</h5>
                                            <ul>
                                                @foreach ($reserv->passages as $passage)
                                                    <li>{{ $passage['jour'] }} : {{ $passage['heure'] }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endisset
                            @endforeach
                        @endisset
                        {{-- if is set entreprise --}}
                        {{-- @isset($user->entreprises)
                            @foreach ($user->entreprises as $entrp)
                                <li class="list-group-item d-flex justify-content-between list-group-item-primary">
                                    <div>
                                        <h5 class="text-bold">Entreprise</h5>
                                        <p class="mb-1">{{ $entrp->nom }}</p>
                                        <p class="mb-1">{{ $entrp->tel }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-bold">Adresse</h5>
                                        <p class="mb-1">{{ $entrp->adresse }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-bold">Ville</h5>
                                        <p class="mb-1">{{ $entrp->ville }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-bold">Description</h5>
                                        <p class="mb-1">{{ $entrp->description }}</p>
                                    </div>
                                </li>
                                <small class="mt-2">
                                    <button type="button" class="float-end btn btn-sm  btn-outline-danger"
                                        data-id="{{ $entrp->id }}" data-bs-toggle="modal" data-bs-target="#ModalDelete">
                                        Supprimer <i class="far fa-trash-alt"></i>
                                    </button>
                                </small>
                            @endforeach
                        @endisset --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card  shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Réservations</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($user->reservations)
                                    @foreach ($user->reservations as $reserv)
                                        @if ($reserv->type_passage == 'unique')
                                            <tr>
                                                <th scope="row">{{ $reserv->id }}</th>
                                                <td>{{ $reserv->service }}</td>
                                                <td>{{ $reserv->date_passage }}</td>
                                                <td>{{ $reserv->heure_passage }}</td>
                                                <td>{{ $reserv->prix }}</td>
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
@endsection
