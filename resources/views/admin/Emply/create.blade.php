@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Employées</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.emply.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">ajouter</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Ajouter un nouveaux employée </h5>
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="{{ route('admin.emply.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    id="firstName" name="first_name" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    id="lastName" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="date_birth" class="form-label ">Date naissance</label>
                                <input type="date" class="form-control @error('date_birth') is-invalid @enderror"
                                    id="age" name="date_birth" value="{{ old('date_birth') }}">
                                @error('date_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <h6>Sex</h6>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="femme" name="sex"
                                        value="F" @if (old('sex') == 'F' || old('sex') == '') checked @endif>
                                    <label class="form-check-label" for="femme">Femme</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="homme" name="sex"
                                        value="M" @if (old('sex') == 'M') checked @endif>
                                    <label class="form-check-label" for="homme">Homme</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="selectSpecialite" class="form-label">specialité</label>
                                <select class="form-select" id="selectSpecialite" name="speciality"
                                    aria-label="Default select example">

                                    <option value="menage" @if (old('speciality') == 'menage' || old('speciality') == '') selected @endif>Ménage</option>
                                    <option value="cuisine" @if (old('speciality') == 'cuisine') selected @endif>Cuisine
                                    </option>
                                    <option value="autre" @if (old('speciality') == 'autre') selected @endif>autre</option>

                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label for="addresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control @error('adress') is-invalid @enderror"
                                    id="addresse" name="adress" value="{{ old('adress') }}">
                                @error('adress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-sm-6">
                                <label for="selectcity" class="form-label">Ville</label>
                                <select class="form-select" id="selectcity" name="city"
                                    aria-label="Default select example">

                                    <option value="Rabat" @if (old('city') == 'Rabat' || old('city') == '') selected @endif>Rabat
                                    </option>
                                    <option value="Casablanca" @if (old('city') == 'Casablanca') selected @endif>
                                        Casablanca
                                    </option>
                                    <option value="Mohammedia" @if (old('city') == 'Mohammedia') selected @endif>
                                        Mohammedia</option>

                                </select>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Ajouter une photo</label>
                                    <input class="form-control @error('image_path') is-invalid @enderror" type="file"
                                        id="formFile" name="image_path">
                                    @error('image_path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <hr class="my-4">
                        <button class="w-100 btn btn-primary btn-lg" type="submit">Ajouter</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
