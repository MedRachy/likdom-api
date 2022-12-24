@extends('layouts.admin')
@section('content')
    @push('css')
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    @endpush
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Employées</h1>
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
                                    <h6 class="fw-bold">Disponibilité</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type1" name="disponible"
                                            value="disponible">
                                        <label class="form-check-label" for="type1">Disponible</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type2" name="disponible"
                                            value="conge">
                                        <label class="form-check-label" for="type2">Congé</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type3" name="disponible"
                                            value="autre">
                                        <label class="form-check-label" for="type3">Autre raison</label>
                                    </div>
                                </div>

                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                                <div>
                                    <h6 class="fw-bold">Employées planifier pour :</h6>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="labeldate_passage">le</span>
                                        <input id="date_passage" type="date" class="form-control"
                                            aria-describedby="labeldate_passage" name="date_passage">
                                    </div>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="labelheure_passage">à</span>
                                        <input id="heure_passage" type="time" class="form-control"
                                            aria-describedby="labelheure_passage" name="heure_passage">
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Réservations</h6>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="radio" id="reserv1" name="reserv"
                                            value="1">
                                        <label class="form-check-label" for="reserv1">au moins une réservation
                                            attribué</label>
                                    </div>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="radio" id="reserv0" name="reserv"
                                            value="0">
                                        <label class="form-check-label" for="reserv0">aucune réservation attribué</label>
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
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Tel</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Disponibilité</th>
                                    <th scope="col">Action</th>
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
                var url = './Emplysearch';
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
                            "data": "nom"
                        },
                        {
                            "data": "prenom"
                        },
                        {
                            "data": "phone"
                        },
                        {
                            "data": "adresse"
                        },
                        {
                            "data": "ville"
                        },
                        {
                            "data": "age"
                        },
                        {
                            "data": "disponibilite"
                        },
                        {
                            "data": 'action',
                            "orderable": false,
                            "searchable": false
                        },
                    ]
                });

                $("#searchButton").click(function() {
                    query = getinputdata();
                    url = './Emplysearch?' + query;
                    // set url params and reload 
                    datatable.ajax.url(url).load();
                });
                $("#clearButton").click(function() {
                    var url = './Emplysearch';
                    datatable.ajax.url(url).load();
                    clearinputs();
                });

                function getinputdata() {
                    var paramsinput = {};
                    var paramschecked = '';
                    var ville = {};
                    var disponible = {};
                    // get input values 
                    $("input:checkbox[name=ville]:checked").each(function(i, e) {
                        ville[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=disponible]:checked").each(function(i, e) {
                        disponible[$(this).val()] = e.checked;
                    });

                    if ($("#date_passage").val()) {
                        paramsinput['date_passage'] = $("#date_passage").val();
                    }
                    if ($("#heure_passage").val()) {
                        paramsinput['heure_passage'] = $("#heure_passage").val();
                    }
                    if ($("input:radio[name=reserv]:checked").val()) {
                        paramsinput['reserv'] = $("input:radio[name=reserv]:checked").val();
                    }
                    // convert object to string param and concatinate 
                    if (!$.isEmptyObject(ville)) {
                        var ville_param = $.param(ville);
                        paramschecked = paramschecked + ville_param + '&';

                    }
                    if (!$.isEmptyObject(disponible)) {
                        var dispo_param = $.param(disponible);
                        paramschecked = paramschecked + dispo_param + '&';
                    }

                    var paramsinput_string = $.param(paramsinput);
                    var params = 'params=true&' + paramschecked + paramsinput_string;
                    // console.log(paramsinput_string);
                    // console.log(paramschecked);
                    // console.log(params);

                    return params;
                }

                function clearinputs() {
                    $('input[type=checkbox]').prop('checked', false);
                    $('input[type=radio]').prop('checked', false);
                    $('input[type=date]').val('');
                    $('input[type=time]').val('');
                };
            });
        </script>
    @endpush
@endsection
