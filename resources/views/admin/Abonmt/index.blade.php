@extends('layouts.admin')
@section('content')
    @push('css')
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    @endpush
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Abonnements</h1>
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
                                <div>
                                    <h6 class="fw-bold">Ville</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville1" name="ville"
                                            value="Rabat">
                                        <label class="form-check-label" for="ville1">Rabat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville2" name="ville"
                                            value="Mohammedia">
                                        <label class="form-check-label" for="ville2">Mohammedia</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville3" name="ville"
                                            value="Casablanca">
                                        <label class="form-check-label" for="ville3">Casablanca</label>
                                    </div>
                                </div>

                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="fw-bold">Pack</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack1" name="pack"
                                            value="Likyoum">
                                        <label class="form-check-label" for="pack1">Likyoum</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack2" name="pack"
                                            value="Likmeta">
                                        <label class="form-check-label" for="pack2">Likmeta</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack3" name="pack"
                                            value="Likdima">
                                        <label class="form-check-label" for="pack3">Likdima</label>
                                    </div>

                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                                <div>
                                    <h6 class="fw-bold">Type logement</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type1"
                                            name="type_logement" value="appartement">
                                        <label class="form-check-label" for="type1">Appartement</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type2"
                                            name="type_logement" value="maison">
                                        <label class="form-check-label" for="type2">Maison</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="type3"
                                            name="type_logement" value="villa">
                                        <label class="form-check-label" for="type3">Villa</label>
                                    </div>
                                </div>
                                <div style="width: 225px;">
                                    <h6 class="fw-bold">Prix</h6>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="min">min</span>
                                        <input id="prix_min" type="number" class="form-control" placeholder=". . ."
                                            aria-label=". . ." aria-describedby="min">
                                    </div>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="max">max</span>
                                        <input id="prix_max" type="number" class="form-control" placeholder=". . ."
                                            aria-label=". . ." aria-describedby="max">
                                    </div>
                                    {{-- <label for="customRange2" class="form-label">Prix</label>
                        <input type="range" class="form-range" min="100" max="500" id="customRange2" 
                        name="rangeInput" min="0" max="100" onchange="updateTextInput(this.value);">
                        <input type="text" id="textInput" value=""> --}}
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                                <div>
                                    <h6 class="fw-bold">Période</h6>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="labeldate_debut">D</span>
                                        <input id="date_debut" type="date" class="form-control"
                                            aria-describedby="labeldate_debut" name="date_debut">
                                    </div>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="labeldate_fin">F</span>
                                        <input id="date_fin" type="date" class="form-control"
                                            aria-describedby="labeldate_fin" name="date_fin">
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
                <h5 class="card-header">Abonnements <span id="count" class="badge bg-primary float-end"></span></h5>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Pack</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Type log</th>
                                    <th scope="col">Date debut</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Statut</th>
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
                var url = './Abonmtsearch';
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
                    // buttons: [
                    //     'copy', 'excel', 'pdf'
                    // ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": url,
                        // "data" : query ,
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "pack"
                        },
                        {
                            "data": "ville"
                        },
                        {
                            "data": "type_logement"
                        },
                        {
                            "data": "date_debut"
                        },
                        {
                            "data": "prix"
                        },
                        {
                            "data": "statut"
                        },
                        {
                            "data": 'action',
                            "orderable": false,
                            "searchable": false
                        },
                    ],
                    "createdRow": function(row, data, index) {
                        if (data["statut"] === "valider") {
                            $('td', row).eq(6).wrapInner('<span class="badge bg-success"></span>');
                        }
                        if (data["statut"] === "terminer") {
                            $('td', row).eq(6).wrapInner('<span class="badge bg-secondary"></span>');
                        }
                        if (data["statut"] === "annuler") {
                            $('td', row).eq(6).wrapInner('<span class="badge bg-danger"></span>');
                        }
                        if (data["statut"] === "en_attente") {
                            $('td', row).eq(6).wrapInner('<span class="badge bg-warning"></span>');
                        }
                    }
                });
                //  count : NOTE cant override ajax success of the table
                // console.log(datatable.page.info().recordsTotal);


                $("#searchButton").click(function() {
                    query = getinputdata();
                    url = './Abonmtsearch?' + query;
                    // set url params and reload 
                    datatable.ajax.url(url).load();
                });
                $("#clearButton").click(function() {
                    var url = './Abonmtsearch';
                    datatable.ajax.url(url).load();
                    clearinputs();
                });

                function getinputdata() {
                    var paramsinput = {};
                    var paramschecked = '';
                    var statut = {};
                    var ville = {};
                    var pack = {};
                    var type_logement = {};
                    // get input values 
                    $("input:checkbox[name=statut]:checked").each(function(i, e) {
                        statut[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=ville]:checked").each(function(i, e) {
                        ville[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=pack]:checked").each(function(i, e) {
                        pack[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=type_logement]:checked").each(function(i, e) {
                        type_logement[$(this).val()] = e.checked;
                    });

                    if ($("#prix_min").val()) {
                        paramsinput['prix_min'] = $("#prix_min").val();
                    }
                    if ($("#prix_max").val()) {
                        paramsinput['prix_max'] = $("#prix_max").val();
                    }
                    if ($("#date_debut").val()) {
                        paramsinput['date_debut'] = $("#date_debut").val();
                    }
                    if ($("#date_fin").val()) {
                        paramsinput['date_fin'] = $("#date_fin").val();
                    }
                    // convert object to string param and concatinate 
                    if (!$.isEmptyObject(statut)) {
                        var statut_param = $.param(statut);
                        paramschecked = statut_param + '&';
                    }
                    if (!$.isEmptyObject(ville)) {
                        var ville_param = $.param(ville);
                        paramschecked = paramschecked + ville_param + '&';

                    }
                    if (!$.isEmptyObject(pack)) {
                        var pack_param = $.param(pack);
                        paramschecked = paramschecked + pack_param + '&';
                    }
                    if (!$.isEmptyObject(type_logement)) {
                        var type_logement_param = $.param(type_logement);
                        paramschecked = paramschecked + type_logement_param + '&';
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
                    $('input[type=date]').val('');
                    $('input[type=number]').val('');
                };
            });
        </script>
    @endpush
@endsection
