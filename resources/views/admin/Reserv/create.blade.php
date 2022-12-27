@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Réservations</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reserv.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">ajouter</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Créer une nouvelle réservation</h5>
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="{{ route('admin.reserv.store') }}">
                        @csrf
                        <div class="row">
                            {{-- Passages --}}
                            <h4 class="mb-3 mt-4">Passage </h4>
                            <div class="accordion" id="accordionPassages">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Passage unique
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionPassages">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="start_date" class="form-label">Date</label>
                                                    <input type="date"
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        id="start_date" name="start_date">
                                                    @error('start_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="start_time" class="form-label">Heure</label>
                                                    <input type="time"
                                                        class="form-control @error('start_time') is-invalid @enderror"
                                                        id="start_time" name="start_time">
                                                    @error('start_time')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                        </div>

                        <hr class="my-4">
                        <h4 class="mb-3 mt-4">Info client </h4>
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
                        <small>* Réservation sera enregister avec statut "en attente"</small>
                        <button class="w-100 btn btn-primary btn-lg" type="submit">Ajouter</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
