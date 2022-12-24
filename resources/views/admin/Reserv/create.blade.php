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
                            {{-- services --}}
                            <h4 class="mb-3 mt-4">Service</h4>
                            <div class="col-sm-6">
                                <label for="selectservice" class="form-label">Service</label>
                                <select class="form-select" id="selectservice" name="service" aria-label="selectservice">
                                    <option value="menage_simple" @if (old('service') == 'menage_simple' || old('service') == '') selected @endif>Ménage
                                        Simple</option>
                                    <option value="grand_menage" @if (old('service') == 'grand_menage') selected @endif>Grand
                                        Ménage</option>
                                    {{-- <option value="cristalisation" @if (old('service') == 'cristalisation') selected @endif>
                                        cristalisation</option>
                                    <option value="desinfection" @if (old('service') == 'desinfection') selected @endif>
                                        Désinfection</option>
                                    <option value="nettoyage_sec" @if (old('service') == 'nettoyage_sec') selected @endif>
                                        nettoyage_sec</option> --}}
                                    {{-- <option value="menage_pro">Pro</option> --}}
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
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Passage unique
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionPassages">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="date_passage" class="form-label">Date</label>
                                                    <input type="date"
                                                        class="form-control @error('date_passage') is-invalid @enderror"
                                                        id="date_passage" name="date_passage">
                                                    @error('date_passage')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="heure_passage" class="form-label">Heure</label>
                                                    <input type="time"
                                                        class="form-control @error('heure_passage') is-invalid @enderror"
                                                        id="heure_passage" name="heure_passage">
                                                    @error('heure_passage')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="accordion-item">
                              <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Passage avec abonnement
                                </button>
                              </h2>
                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionPassages">
                                <div class="accordion-body bg-white">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="date_debut" class="form-label">Date Début</label>
                                            <input type="date" class="form-control" id="date_debut" name="date">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="date_fin" class="form-label">Date Fin</label>
                                            <input type="date" class="form-control" id="date_fin" name="date_fin">
                                        </div>  
                                        <div class="col-sm-6 mx-auto">
                                            <div class="input-group mt-2">
                                                <div class="input-group-text">
                                                <input class="form-check-input mt-0 " type="checkbox" value="" aria-label="Checkbox for following text input">
                                                <span class="mx-1">Lundi</span>    
                                                </div>
                                                <input type="time" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                            
                                        
                                        
                                            <div class="input-group mt-2">
                                                <div class="input-group-text">
                                                <input class="form-check-input mt-0 " type="checkbox" value="" aria-label="Checkbox for following text input">
                                                <span class="mx-1">Mardi</span>    
                                                </div>
                                                <input type="time" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                            
                                                                               
                                        
                                            <div class="input-group mt-2">
                                                <div class="input-group-text">
                                                <input class="form-check-input mt-0 " type="checkbox" value="" aria-label="Checkbox for following text input">
                                                <span class="mx-1">Mercredi</span>    
                                                </div>
                                                <input type="time" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                            
                                                                              
                                       
                                            <div class="input-group mt-2">
                                                <div class="input-group-text">
                                                <input class="form-check-input mt-0 " type="checkbox" value="" aria-label="Checkbox for following text input">
                                                <span class="mx-1">Jeudi</span>    
                                                </div>
                                                <input type="time" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                            
                                        
                                            <div class="input-group mt-2">
                                                <div class="input-group-text">
                                                <input class="form-check-input mt-0 " type="checkbox" value="" aria-label="Checkbox for following text input">
                                                <span class="mx-1">Vendredi</span>    
                                                </div>
                                                <input type="time" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                            
                                      
                                            <div class="input-group mt-2">
                                                <div class="input-group-text">
                                                <input class="form-check-input mt-0 " type="checkbox" value="" aria-label="Checkbox for following text input">
                                                <span class="mx-1">Samedi</span>    
                                                </div>
                                                <input type="time" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                            
                             
                                            <div class="input-group mt-2">
                                                <div class="input-group-text">
                                                <input class="form-check-input mt-0 " type="checkbox" value="" aria-label="Checkbox for following text input">
                                                <span class="mx-1">Dimanche</span>    
                                                </div>
                                                <input type="time" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div> --}}
                            </div>
                            {{-- Taches --}}
                            {{-- <h4 class="mb-3 mt-4">Tâches ménagers</h4> --}}
                            {{-- <div class="accordion" id="accordionTaches">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTaches">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTaches"
                                            aria-expanded="false" aria-controls="collapseTaches">
                                            Liste des tâches
                                        </button>
                                    </h2>
                                    <div id="collapseTaches" class="accordion-collapse collapse"
                                        aria-labelledby="headingTaches" data-bs-parent="#accordionTaches">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="taches[]"
                                                            value="Nettoyer les murs et le plafond" id="tache1">
                                                        <label class="form-check-label" for="tache1">
                                                            Nettoyer les murs et le plafond
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="taches[]"
                                                            value="Nettoyer le réfrigérateur (extérieur / intérieur)"
                                                            id="tache2">
                                                        <label class="form-check-label" for="tache2">
                                                            Nettoyer le réfrigérateur (extérieur / intérieur)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="taches[]"
                                                            value="Enlever les salles du four et micro-ondes"
                                                            id="tache3">
                                                        <label class="form-check-label" for="tache3">
                                                            Enlever les salles du four et micro-ondes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="taches[]"
                                                            value="Nettoyer les placards de cuisine" id="tache4">
                                                        <label class="form-check-label" for="tache4">
                                                            Nettoyer les placards de cuisine
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="taches[]"
                                                            value="Repassage et plie" id="tache5">
                                                        <label class="form-check-label" for="tache5">
                                                            Repassage et plie
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- Nos Produits --}}
                            <h4 class="mb-3 mt-4">Produits / Equipements</h4>
                            <div class="accordion" id="accordionProduits">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingProduits">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseProduits"
                                            aria-expanded="false" aria-controls="collapseProduits">
                                            Produits et équipements
                                        </button>
                                    </h2>
                                    <div id="collapseProduits" class="accordion-collapse collapse"
                                        aria-labelledby="headingProduits" data-bs-parent="#accordionProduits">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="produits"
                                                            value="1" id="produits">
                                                        <label class="form-check-label" for="produits">
                                                            Séléctionner avec produits/equipements
                                                        </label>
                                                    </div>
                                                    <small>* Réservation sera enregister avec statut "en attente"</small>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>Nettoyants :</h5>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="marbre"
                                                            id="Marbre" name="type_surface[]">
                                                        <label class="form-check-label" for="Marbre">
                                                            Marbre
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="cuir"
                                                            id="Cuir" name="type_surface[]">
                                                        <label class="form-check-label" for="Cuir">
                                                            Cuir
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="carrelage"
                                                            id="Carrelage" name="type_surface[]">
                                                        <label class="form-check-label" for="Carrelage">
                                                            Carrelage
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="moquette"
                                                            id="Moquette" name="type_surface[]">
                                                        <label class="form-check-label" for="Moquette">
                                                            Moquette
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="bois"
                                                            id="Bois" name="type_surface[]">
                                                        <label class="form-check-label" for="Bois">
                                                            Bois
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="parquet"
                                                            id="Parquet" name="type_surface[]">
                                                        <label class="form-check-label" for="Parquet">
                                                            Parquet
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>Equipements :</h5>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="aspirateur" id="aspirateur" name="equipements[]">
                                                        <label class="form-check-label" for="aspirateur">
                                                            aspirateur
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="equip2"
                                                            id="equip2" name="equipements[]">
                                                        <label class="form-check-label" for="equip2">
                                                            equip2
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="equip3"
                                                            id="equip3" name="equipements[]">
                                                        <label class="form-check-label" for="equip3">
                                                            equip3
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr class="my-4">
                        <h4 class="mb-3 mt-4">Client / User </h4>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
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
