@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Employées</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.emply.index') }}">liste</a> </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.emply.show', $employee->id) }}">employée</a> </li>
                <li class="breadcrumb-item active">modifier</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Modifier </h5>
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="{{ route('admin.emply.update', $employee->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- emply info --}}
                        {{-- <h4 class="mb-3 mt-4">Client info</h4> --}}
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                                    id="firstName" name="prenom" value="{{ $employee->prenom }}">
                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="lastName"
                                    name="nom" value="{{ $employee->nom }}">
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="age" class="form-label">Age</label>
                                <input type="text" class="form-control @error('age') is-invalid @enderror" id="age"
                                    name="age" value="{{ $employee->age }}">
                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <h6>Sex</h6>
                                @if ($employee->sex == 'F')
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="femme" name="sex"
                                            value="F" checked>
                                        <label class="form-check-label" for="femme">Femme</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="homme" name="sex"
                                            value="H">
                                        <label class="form-check-label" for="homme">Homme</label>
                                    </div>
                                @else
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="femme" name="sex"
                                            value="F">
                                        <label class="form-check-label" for="femme">Femme</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="homme" name="sex"
                                            value="H" checked>
                                        <label class="form-check-label" for="homme">Homme</label>
                                    </div>
                                @endif

                            </div>

                            <div class="col-sm-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ $employee->phone }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="selectSpecialite" class="form-label">specialité</label>
                                <select class="form-select" id="selectSpecialite" name="specialite"
                                    aria-label="Default select example">
                                    @if ($employee->specialite == 'menage')
                                        <option value="menage" selected>Ménage</option>
                                        <option value="cuisine">Cuisine</option>
                                        <option value="autre">autre</option>
                                    @elseif ($employee->specialite == 'cuisine')
                                        <option value="menage">Ménage</option>
                                        <option value="cuisine" selected>Cuisine</option>
                                        <option value="autre">autre</option>
                                    @endif


                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label for="addresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control @error('adresse') is-invalid @enderror"
                                    id="addresse" name="adresse" value="{{ $employee->adresse }}">
                                @error('adresse')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-sm-6">
                                <label for="selectVille" class="form-label">Ville</label>
                                <select class="form-select" id="selectVille" name="ville"
                                    aria-label="Default select example">
                                    @if ($employee->ville == 'Rabat')
                                        <option value="Rabat" selected>Rabat</option>
                                        <option value="Casablanca">Casablanca</option>
                                        <option value="Mohammedia">Mohammedia</option>
                                    @elseif ($employee->ville == 'Casablanca')
                                        <option value="Rabat">Rabat</option>
                                        <option value="Casablanca" selected>Casablanca</option>
                                        <option value="Mohammedia">Mohammedia</option>
                                    @elseif ($employee->ville == 'Mohammedia')
                                        <option value="Rabat">Rabat</option>
                                        <option value="Casablanca">Casablanca</option>
                                        <option value="Mohammedia" selected>Mohammedia</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Modifier la photo</label>
                                    <input class="form-control @error('image_path') is-invalid @enderror" type="file"
                                        id="formFile" name="image_path">
                                    @error('image_path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="selectDispo" class="form-label">Disponibilité</label>
                                <select class="form-select" id="selectDispo" name="disponibilite"
                                    aria-label="Default select example">
                                    @if ($employee->disponibilite == 'disponible')
                                        <option value="disponibile" selected>Disponibile</option>
                                        <option value="conge">Congé</option>
                                        <option value="autre">Autre</option>
                                    @elseif ($employee->disponibilite == 'conge')
                                        <option value="disponibile">Disponibile</option>
                                        <option value="conge" selected>Congé</option>
                                        <option value="autre">Autre</option>
                                    @elseif ($employee->disponibilite == 'autre')
                                        <option value="disponibile">Disponibile</option>
                                        <option value="conge">Congé</option>
                                        <option value="autre" selected>Autre</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <hr class="my-4">

                        <button class="w-100 btn btn-primary btn-lg" type="submit">Enregistrer</button>


                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
