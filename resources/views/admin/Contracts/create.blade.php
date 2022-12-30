@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Contrats</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contracts.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">ajouter</li>
            </ol>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nouvelle contrat</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.contracts.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Ref utilisateur</label>

                            <div class="col-md-6">
                                <input id="user_id" type="text"
                                    class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                    value="{{ old('user_id') }}">

                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="subscription_id" class="col-md-4 col-form-label text-md-right">Ref
                                abonnement</label>

                            <div class="col-md-6">
                                <input id="subscription_id" type="text"
                                    class="form-control @error('subscription_id') is-invalid @enderror"
                                    name="subscription_id" value="{{ old('subscription_id') }}"
                                    autocomplete="subscription_id">

                                @error('subscription_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="manager_name" class="col-md-4 col-form-label text-md-right">Nom et prénom du
                                gérant</label>

                            <div class="col-md-6">
                                <input id="manager_name" type="text"
                                    class="form-control @error('manager_name') is-invalid @enderror" name="manager_name"
                                    value="{{ old('manager_name') }}">

                                @error('manager_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right">Raison social</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text"
                                    class="form-control @error('company_name') is-invalid @enderror" name="company_name"
                                    value="{{ old('company_name') }}">

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-right">Ville</label>

                            <div class="col-md-6">
                                <input id="city" type="text"
                                    class="form-control @error('city') is-invalid @enderror" name="city"
                                    value="{{ old('city') }}">

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="adress" class="col-md-4 col-form-label text-md-right">Adresse</label>

                            <div class="col-md-6">
                                <input id="adress" type="text"
                                    class="form-control @error('adress') is-invalid @enderror" name="adress"
                                    value="{{ old('adress') }}">

                                @error('adress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="rc_number" class="col-md-4 col-form-label text-md-right">RC number</label>

                            <div class="col-md-6">
                                <input id="rc_number" type="text"
                                    class="form-control @error('rc_number') is-invalid @enderror" name="rc_number"
                                    value="{{ old('rc_number') }}">

                                @error('rc_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="capital" class="col-md-4 col-form-label text-md-right">Capital</label>

                            <div class="col-md-6">
                                <input id="capital" type="text"
                                    class="form-control @error('capital') is-invalid @enderror" name="capital"
                                    value="{{ old('capital') }}">

                                @error('capital')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <label for="cin_number" class="col-md-4 col-form-label text-md-right">Numéro de la CIN</label>

                            <div class="col-md-6">
                                <input id="cin_number" type="text"
                                    class="form-control @error('cin_number') is-invalid @enderror" name="cin_number"
                                    value="{{ old('cin_number') }}">

                                @error('cin_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

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
