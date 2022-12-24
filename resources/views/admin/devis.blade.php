@extends('layouts.admin')
@section('content')
    @push('css')
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    @endpush
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="mt-4">Devis</h1>
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

                                </div>

                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="fw-bold">Services</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="service1" name="service"
                                            value="nett_pro">
                                        <label class="form-check-label" for="service1">Nettoyage Pro</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="service2" name="service"
                                            value="nett_sec">
                                        <label class="form-check-label" for="service2">Lavage à sec</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="service3" name="service"
                                            value="nett_vitre">
                                        <label class="form-check-label" for="service3">Nettoyage de vitre</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="service4" name="service"
                                            value="cristalisation">
                                        <label class="form-check-label" for="service4">Cristalisation</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="service5" name="service"
                                            value="desinfection">
                                        <label class="form-check-label" for="service5">Désinfection</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="service6" name="service"
                                            value="jardinage">
                                        <label class="form-check-label" for="service6">Jardinage</label>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Produits</h6>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="radio" id="reserv1" name="produits"
                                            value="1">
                                        <label class="form-check-label" for="reserv1">Avec produits & équipements</label>
                                    </div>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="radio" id="reserv0" name="produits"
                                            value="0">
                                        <label class="form-check-label" for="reserv0">Sans produits & équipements</label>
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
                <h5 class="card-header">Devis <span id="count" class="badge bg-primary float-end"></span></h5>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Entrep</th>
                                    <th scope="col">Tél</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Détails</th>
                                    <th scope="col">Services</th>
                                    <th scope="col">Produits</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Statut</th>
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
                var url = './Devisearch';
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
                            "data": "name"
                        },
                        {
                            "data": "entreprise"
                        },
                        {
                            "data": "phone"
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "details"
                        },
                        {
                            "data": "services"
                        },
                        {
                            "data": "produits"
                        },
                        {
                            "data": "prix"
                        },
                        {
                            "data": "statut"
                        },

                    ],
                    "createdRow": function(row, data, index) {
                        if (data["statut"] === "valider") {
                            $('td', row).eq(9).wrapInner('<span class="badge bg-success"></span>');
                        }
                        if (data["statut"] === "terminer") {
                            $('td', row).eq(9).wrapInner('<span class="badge bg-secondary"></span>');
                        }
                        if (data["statut"] === "annuler") {
                            $('td', row).eq(9).wrapInner('<span class="badge bg-danger"></span>');
                        }
                        if (data["statut"] === "en_attente") {
                            $('td', row).eq(9).wrapInner('<span class="badge bg-warning"></span>');
                        }
                    }
                });
                //  count : NOTE cant override ajax success of the table
                // console.log(datatable.page.info().recordsTotal);


                $("#searchButton").click(function() {
                    query = getinputdata();
                    url = './Devisearch?' + query;
                    // set url params and reload 
                    datatable.ajax.url(url).load();
                });
                $("#clearButton").click(function() {
                    var url = './Devisearch';
                    datatable.ajax.url(url).load();
                    clearinputs();
                });

                function getinputdata() {
                    var paramsinput = {};
                    var paramschecked = '';
                    var statut = {};
                    var service = {};
                    // get input values 
                    $("input:checkbox[name=statut]:checked").each(function(i, e) {
                        statut[$(this).val()] = e.checked;
                    });

                    $("input:checkbox[name=service]:checked").each(function(i, e) {
                        service[$(this).val()] = e.checked;
                    });

                    if ($("input:radio[name=produits]:checked").val()) {
                        paramsinput['produits'] = $("input:radio[name=produits]:checked").val();
                    }
                    if ($("#prix_min").val()) {
                        paramsinput['prix_min'] = $("#prix_min").val();
                    }
                    if ($("#prix_max").val()) {
                        paramsinput['prix_max'] = $("#prix_max").val();
                    }

                    // convert object to string param and concatinate 
                    if (!$.isEmptyObject(statut)) {
                        var statut_param = $.param(statut);
                        paramschecked = statut_param + '&';
                    }
                    if (!$.isEmptyObject(service)) {
                        var service_param = $.param(service);
                        paramschecked = paramschecked + service_param + '&';
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
                    $('input[type=number]').val('');
                };
            });
        </script>
    @endpush
@endsection
