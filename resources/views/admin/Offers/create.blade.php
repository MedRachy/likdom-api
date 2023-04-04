@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Offres de likdom</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.offer.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">ajouter</li>
            </ol>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nouvelle offre</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.offer.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="label" class="col-md-4 col-form-label text-md-right">{{ __('Label') }}</label>

                            <div class="col-md-6">
                                <input id="label" type="text"
                                    class="form-control @error('label') is-invalid @enderror" name="label"
                                    value="{{ old('label') }}" autocomplete="label" autofocus>

                                @error('label')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Déscription') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    value="{{ old('description') }}" autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nbr_passages"
                                class="col-md-4 col-form-label text-md-right">{{ __('Nombre de pasasges par semaine') }}</label>

                            <div class="col-md-6">
                                <input id="nbr_passages" type="text"
                                    class="form-control @error('nbr_passages') is-invalid @enderror" name="nbr_passages"
                                    value="{{ old('nbr_passages') }}">

                                @error('nbr_passages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start_price"
                                class="col-md-4 col-form-label text-md-right">{{ __('prix à partir de') }}</label>

                            <div class="col-md-6">
                                <input id="start_price" type="text"
                                    class="form-control @error('start_price') is-invalid @enderror" name="start_price"
                                    value="{{ old('start_price') }}">

                                @error('start_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="selectuser_type" class="col-md-4 col-form-label text-md-right">Type d'offre</label>
                            <div class="col-md-6">
                                <select class="form-select  @error('user_type') is-invalid @enderror" id="selectuser_type"
                                    name="user_type">
                                    <option value="pro" {{ old('user_type') === 'pro' ? 'selected' : '' }}>Pro</option>
                                    <option value="part" {{ old('user_type') === 'part' ? 'selected' : '' }}>Part
                                    </option>
                                </select>
                            </div>

                        </div>




                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enregistrer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
