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
                            <h4 class="mb-3 mt-4">Pack</h4>
                            <div class="col-sm-6">
                                <label for="selectpack" class="form-label">Pack</label>
                                <select class="form-select" id="selectpack" name="pack_id" aria-label="selectpack">
                                    <option value="1" @if (old('pack_id') == '1' || old('pack_id') == '') selected @endif>Likyoum
                                    </option>
                                    <option value="2" @if (old('pack_id') == '2') selected @endif>Likmeta
                                    </option>
                                    <option value="3" @if (old('pack_id') == '3') selected @endif>
                                        Likdima</option>
                                </select>
                            </div>
                            {{-- type_logement --}}
                            <div class="col-sm-6">
                                <label for="select_typemaison" class="form-label">Type de logement</label>
                                <select class="form-select" id="select_typemaison" name="type_logement"
                                    aria-label="selectservice">
                                    <option value="maison" @if (old('type_logement') == 'maison' || old('service') == '') selected @endif>Maison</option>
                                    <option value="appartement" @if (old('type_logement') == 'appartement') selected @endif>
                                        Appartement</option>
                                    <option value="villa" @if (old('type_logement') == 'villa') selected @endif>Villa</option>

                                </select>
                            </div>
                            {{-- Pieces --}}
                            <h4 class="mb-3 mt-4">Piéces</h4>
                            <div class="accordion" id="accordionPieces">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPieces">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePieces" aria-expanded="false"
                                            aria-controls="collapsePieces">
                                            Nombre de piéces
                                        </button>
                                    </h2>
                                    <div id="collapsePieces" class="accordion-collapse collapse"
                                        aria-labelledby="headingPieces" data-bs-parent="#accordionPieces">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="niveau" class="form-label">Niveau</label>
                                                    <input type="number" class="form-control" id="niveau" name="niveau"
                                                        value="1">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="chambre" class="form-label">Chambre</label>
                                                    <input type="number" class="form-control" id="chambre" name="chambre"
                                                        value="1">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="cuisine" class="form-label">Cuisine</label>
                                                    <input type="number" class="form-control" id="cuisine" name="cuisine"
                                                        value="1">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="toilette" class="form-label">Toilette</label>
                                                    <input type="number" class="form-control" id="toilette"
                                                        name="toilette" value="1">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="salon_traditionnel" class="form-label">Salon
                                                        traditionnel</label>
                                                    <input type="number" class="form-control" id="salon_traditionnel"
                                                        name="salon_traditionnel" value="1">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="salon_moderne" class="form-label">Salon moderne</label>
                                                    <input type="number" class="form-control" id="salon_moderne"
                                                        name="salon_moderne" value="0">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sejoure" class="form-label">Sejoure</label>
                                                    <input type="number" class="form-control" id="sejoure"
                                                        name="sejoure" value="0">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="cour" class="form-label">Coure</label>
                                                    <input type="number" class="form-control" id="cour"
                                                        name="coure" value="0">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="terasse" class="form-label">Terasse</label>
                                                    <input type="number" class="form-control" id="terasse"
                                                        name="terasse" value="0">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="buanderie" class="form-label">Buanderie</label>
                                                    <input type="number" class="form-control" id="buanderie"
                                                        name="buanderie" value="0">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="garage" class="form-label">Garage</label>
                                                    <input type="number" class="form-control" id="garage"
                                                        name="garage" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Passages --}}
                            <h4 class="mb-3 mt-4">Passage </h4>
                            <div class="accordion" id="accordionPassages">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Passage avec abonnement
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionPassages">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                                <div class="col-sm-6 me-auto">
                                                    <label for="date_debut" class="form-label">Date Début</label>
                                                    <input type="date" class="form-control" id="date_debut"
                                                        name="date_debut">
                                                </div>

                                                <div class="col-sm-6 mx-auto">
                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Lundi" name="jour[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Lundi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Lundi"
                                                            aria-label="Text input with checkbox">
                                                    </div>


                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Mardi" name="jour[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Mardi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Mardi"
                                                            aria-label="Text input with checkbox">
                                                    </div>


                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Mercredi" name="jour[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Mercredi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Mercredi"
                                                            aria-label="Text input with checkbox">
                                                    </div>


                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Jeudi" name="jour[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Jeudi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Jeudi"
                                                            aria-label="Text input with checkbox">
                                                    </div>

                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Vendredi" name="jour[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Vendredi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Vendredi"
                                                            aria-label="Text input with checkbox">
                                                    </div>

                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Samedi" name="jour[]"
                                                                aria-label="Checkbox for following text input">
                                                            <span class="mx-1">Samedi</span>
                                                        </div>
                                                        <input type="time" class="form-control" name="Samedi"
                                                            aria-label="Text input with checkbox">
                                                    </div>

                                                    <div class="input-group mt-2">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0 " type="checkbox"
                                                                value="Dimanche" name="jour[]"
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
                        <div class="mb-3">
                            <label for="Emp_selected" class="form-label">Employée souhaiter</label>
                            <input type="text" class="form-control w-25" id="Emp_selected" name="Emp_selected"
                                placeholder="Emp_selected">
                            @error('Emp_selected')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <h4 class="mb-3 mt-4">Client / User </h4>
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
                            <input type="text" class="form-control w-25" id="ville" name="ville"
                                placeholder="ville">
                            @error('ville')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" class="form-control w-25" id="adresse" name="adresse"
                                placeholder="adresse">
                            @error('adresse')
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
                        <small>* Réservation sera enregister avec statut "en attente"</small>
                        <button class="w-100 btn btn-primary btn-lg" type="submit">Ajouter</button>


                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
