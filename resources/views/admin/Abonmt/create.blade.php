@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Abonnement</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.abonmt.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">ajouter</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Créer un nouveaux abonnement</h5>
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="{{ route('admin.abonmt.store') }}">
                        @csrf
                        <div class="row">
                            {{-- pack --}}
                            <h4 class="mb-3 mt-4">Offre</h4>
                            <div class="col-sm-6">
                                <label for="selectpack" class="form-label">Offre</label>
                                <select class="form-select" id="selectpack" name="offer_id" aria-label="selectpack">
                                    <option value="1" @if (old('offer_id') == '1' || old('offer_id') == '') selected @endif>Offre1 name
                                    </option>
                                    <option value="2" @if (old('offer_id') == '2') selected @endif>Offre2 name
                                    </option>
                                    <option value="3" @if (old('offer_id') == '3') selected @endif>
                                        Offre3 name</option>
                                    <option value="4" @if (old('offer_id') == '4') selected @endif>
                                        Offre4 name</option>
                                    <option value="5" @if (old('offer_id') == '5') selected @endif>
                                        Offre5 name</option>
                                    <option value="6" @if (old('offer_id') == '6') selected @endif>
                                        Offre6 name</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="nbrMonth" class="form-label">Durée d'engagement</label>
                                <input type="text" class="form-control @error('nbr_months') is-invalid @enderror"
                                    id="nbrMonth" name="nbr_months" placeholder="3 , 6 , 12 ..."
                                    value="{{ old('nbr_months') }}">
                                @error('nbr_months')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-4"></div>
                            <div class="col-sm-6">
                                <label for="selectnbrHeure" class="form-label">Nombre d'heure par passage</label>
                                <select class="form-select" id="selectnbrHeure" name="nbr_hours"
                                    aria-label="selectnbrHeure">
                                    <option value="1" @if (old('nbr_hours') == '1' || old('nbr_hours') == '') selected @endif>
                                        1</option>
                                    <option value="2" @if (old('nbr_hours') == '2') selected @endif>
                                        2</option>
                                    <option value="3" @if (old('nbr_hours') == '3') selected @endif>
                                        3</option>
                                    <option value="4" @if (old('nbr_hours') == '4') selected @endif>
                                        4</option>
                                    <option value="5" @if (old('nbr_hours') == '5') selected @endif>
                                        5</option>
                                    <option value="6" @if (old('nbr_hours') == '6') selected @endif>
                                        6</option>
                                    <option value="7" @if (old('nbr_hours') == '7') selected @endif>
                                        7</option>
                                    <option value="8" @if (old('nbr_hours') == '8') selected @endif>
                                        8</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="selectnbrEmpl" class="form-label">Nombre d'employees</label>
                                <select class="form-select" id="selectnbrEmpl" name="nbr_employees"
                                    aria-label="selectnbrEmpl">
                                    <option value="1" @if (old('nbr_employees') == '1' || old('nbr_employees') == '') selected @endif>
                                        1</option>
                                    <option value="2" @if (old('nbr_employees') == '2') selected @endif>
                                        2</option>
                                    <option value="3" @if (old('nbr_employees') == '3') selected @endif>
                                        3</option>
                                    <option value="4" @if (old('nbr_employees') == '4') selected @endif>
                                        4</option>
                                </select>
                            </div>
                            {{-- Passages --}}
                            <h4 class="mb-3 mt-4">Passage </h4>
                            <div class="accordion" id="accordionPassages">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Détails du passage
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordionPassages">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                                <div class="col-sm-6 me-auto">
                                                    <label for="start_date" class="form-label">Date Début</label>
                                                    <input type="date" class="form-control" id="start_date"
                                                        name="start_date">
                                                </div>

                                                <div class="col-sm-6 mx-auto">
                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Lundi" name="day[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Lundi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Lundi"
                                                            aria-label="Text input with checkbox">
                                                    </div>


                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Mardi" name="day[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Mardi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Mardi"
                                                            aria-label="Text input with checkbox">
                                                    </div>


                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Mercredi" name="day[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Mercredi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Mercredi"
                                                            aria-label="Text input with checkbox">
                                                    </div>


                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Jeudi" name="day[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Jeudi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Jeudi"
                                                            aria-label="Text input with checkbox">
                                                    </div>

                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Vendredi" name="day[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Vendredi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Vendredi"
                                                            aria-label="Text input with checkbox">
                                                    </div>

                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Samedi" name="day[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Samedi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Samedi"
                                                            aria-label="Text input with checkbox">
                                                    </div>

                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Dimanche" name="day[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Dimanche</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Dimanche"
                                                            aria-label="Text input with checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h4 class="mb-3 mt-4">Info client / user </h4>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">user ID</label>
                            <input type="text" class="form-control w-25" id="user_id" name="user_id"
                                placeholder="user_id">
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" class="form-control w-25" id="ville" name="city"
                                placeholder="ville">
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" class="form-control w-25" id="adresse" name="adress"
                                placeholder="adresse">
                            @error('adress')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="confirmed" value="1"
                                id="confirmed">
                            <label class="form-check-label" for="confirmed">
                                Confirmer par le client
                            </label>
                        </div>
                        <small>* Abonnement sera enregister avec statut "en attente"</small>
                        <button class="w-100 btn btn-primary btn-lg" type="submit">Ajouter</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
