@extends('layouts.admin')
@section('content')
    @push('css')
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    @endpush
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Candidatures</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active">liste</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header" style="transform: rotate(0);">Recherche
                    <a class="link-recherche collapsed float-end text-decoration-none stretched-link"
                        data-bs-toggle="collapse" href="#collapseRecherche" aria-expanded="false"
                        aria-controls="collapseRecherche">
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                </h5>

                <div class="collapse" id="collapseRecherche">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="fw-bold">Ville</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville1" name="ville"
                                            value="Rabat">
                                        <label class="form-check-label" for="ville1">Rabat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville2" name="ville"
                                            value="Casablanca">
                                        <label class="form-check-label" for="ville2">Casablanca</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville3" name="ville"
                                            value="Mohammedia">
                                        <label class="form-check-label" for="ville3">Mohammedia</label>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Spécialité</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type1" name="specialite"
                                            value="menage">
                                        <label class="form-check-label" for="type1">Ménage</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type2" name="specialite"
                                            value="cuisine">
                                        <label class="form-check-label" for="type2">Cuisine</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type3" name="specialite"
                                            value="jardinage">
                                        <label class="form-check-label" for="type3">Jardinage</label>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Statut</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="en_attente" name="statut"
                                            value="en_attente">
                                        <label class="form-check-label" for="en_attente">En attente</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="valider" name="statut"
                                            value="valider">
                                        <label class="form-check-label" for="valider">Valider</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="annuler" name="statut"
                                            value="annuler">
                                        <label class="form-check-label" for="annuler">Annuler</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="terminer" name="statut"
                                            value="terminer">
                                        <label class="form-check-label" for="terminer">Terminer</label>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item ">
                                <button id="clearButton" class="btn btn btn-secondary float-start mt-2"><i
                                        class="fas fa-times"></i> Effacer la recherche </button>
                                <button id="searchButton" class="btn btn-primary mt-2 float-end">Afficher la
                                    liste</button>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Employees <span id="count" class="badge bg-primary float-end"></span></h5>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Nom & Prénom</th>
                                    <th scope="col">date_naissance</th>
                                    <th scope="col">Tel</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">specialite</th>
                                    <th scope="col">statut</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js">
        </script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js">
        </script>
        <script>
            $(document).ready(function() {

                var query = '';
                var url = './Candidatsearch';
                // init datatable
                var datatable = $('#myTable').DataTable({
                    "pageLength": 25,
                    "responsive": true,
                    "language": {
                        "info": "Lister _START_ à _END_ sur _TOTAL_ entries",
                        "search": "chercher :",
                        "emptyTable": "Aucune donnée disponible",
                        "loadingRecords": "Chargement en cours ...",
                        "paginate": {
                            "first": "Première page",
                            "last": "Dernière page",
                            "next": "Suivant",
                            "previous": "Précédent"
                        },
                        "lengthMenu": "Afficher _MENU_ Reservs",
                    },
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": url,
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "date_naissance"
                        },
                        {
                            "data": "phone"
                        },
                        {
                            "data": "ville"
                        },
                        {
                            "data": "adresse"
                        },
                        {
                            "data": "specialite"
                        },
                        {
                            "data": "statut"
                        },
                    ]
                });

                $("#searchButton").click(function() {
                    query = getinputdata();
                    url = './Candidatsearch?' + query;
                    // set url params and reload 
                    datatable.ajax.url(url).load();
                });
                $("#clearButton").click(function() {
                    var url = './Candidatsearch';
                    datatable.ajax.url(url).load();
                    clearinputs();
                });

                function getinputdata() {
                    var paramschecked = '';
                    var ville = {};
                    var specialite = {};
                    var statut = {};
                    // get input values 
                    $("input:checkbox[name=ville]:checked").each(function(i, e) {
                        ville[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=specialite]:checked").each(function(i, e) {
                        specialite[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=statut]:checked").each(function(i, e) {
                        statut[$(this).val()] = e.checked;
                    });

                    // convert object to string param and concatinate 
                    if (!$.isEmptyObject(ville)) {
                        var ville_param = $.param(ville);
                        paramschecked = paramschecked + ville_param + '&';

                    }
                    if (!$.isEmptyObject(specialite)) {
                        var dispo_param = $.param(specialite);
                        paramschecked = paramschecked + dispo_param + '&';
                    }
                    if (!$.isEmptyObject(statut)) {
                        var statut_param = $.param(statut);
                        paramschecked = statut_param + '&';
                    }

                    var params = 'params=true&' + paramschecked
                    // console.log(paramsinput_string);
                    // console.log(paramschecked);
                    // console.log(params);

                    return params;
                }

                function clearinputs() {
                    $('input[type=checkbox]').prop('checked', false);
                };
            });
        </script>
    @endpush
@endsection
