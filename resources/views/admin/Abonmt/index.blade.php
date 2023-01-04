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
                                        <input class="form-check-input" type="checkbox" id="pending" name="status"
                                            value="pending">
                                        <label class="form-check-label" for="pending">En attente</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="valid" name="status"
                                            value="valid">
                                        <label class="form-check-label" for="valid">Valider</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cancel" name="status"
                                            value="cancel">
                                        <label class="form-check-label" for="cancel">Annuler</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="concluded" name="status"
                                            value="concluded">
                                        <label class="form-check-label" for="concluded">Terminer</label>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Ville</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville1" name="city"
                                            value="Rabat">
                                        <label class="form-check-label" for="ville1">Rabat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville2" name="city"
                                            value="Mohammedia">
                                        <label class="form-check-label" for="ville2">Mohammedia</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ville3" name="city"
                                            value="Casablanca">
                                        <label class="form-check-label" for="ville3">Casablanca</label>
                                    </div>
                                </div>

                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="fw-bold">Offres</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack1" name="offer"
                                            value="offer_1">
                                        <label class="form-check-label" for="pack1">Offre N°1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack2" name="offer"
                                            value="offer_2">
                                        <label class="form-check-label" for="pack2">Offre N°2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack3" name="offer"
                                            value="offer_3">
                                        <label class="form-check-label" for="pack3">Offre N°3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack4" name="offer"
                                            value="offer_4">
                                        <label class="form-check-label" for="pack4">Offre N°4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack5" name="offer"
                                            value="offer_5">
                                        <label class="form-check-label" for="pack5">Offre N°5</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pack6" name="offer"
                                            value="offer_6">
                                        <label class="form-check-label" for="pack6">Offre N°6</label>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                                <div>
                                    <h6 class="fw-bold">Période</h6>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="labelstart_date">D</span>
                                        <input id="start_date" type="date" class="form-control"
                                            aria-describedby="labelstart_date" name="start_date">
                                    </div>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="labelend_date">F</span>
                                        <input id="end_date" type="date" class="form-control"
                                            aria-describedby="labelend_date" name="end_date">
                                    </div>
                                </div>
                                <div style="width: 225px;">
                                    <h6 class="fw-bold">Prix</h6>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="min">min</span>
                                        <input id="min_price" type="number" class="form-control" placeholder=". . ."
                                            aria-label=". . ." aria-describedby="min">
                                    </div>
                                    <div class="input-group flex-nowrap m-1">
                                        <span class="input-group-text" id="max">max</span>
                                        <input id="max_price" type="number" class="form-control" placeholder=". . ."
                                            aria-label=". . ." aria-describedby="max">
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
                                    <th scope="col">Offre</th>
                                    <th scope="col">Ville</th>
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
                            "data": "offer"
                        },
                        {
                            "data": "city"
                        },
                        {
                            "data": "start_date"
                        },
                        {
                            "data": "price"
                        },
                        {
                            "data": "status"
                        },
                        {
                            "data": 'action',
                            "orderable": false,
                            "searchable": false
                        },
                    ],
                    "createdRow": function(row, data, index) {
                        if (data["status"] === "valid") {
                            $('td', row).eq(5).wrapInner('<span class="badge bg-success"></span>');
                        }
                        if (data["status"] === "concluded") {
                            $('td', row).eq(5).wrapInner('<span class="badge bg-secondary"></span>');
                        }
                        if (data["status"] === "cancel") {
                            $('td', row).eq(5).wrapInner('<span class="badge bg-danger"></span>');
                        }
                        if (data["status"] === "pending") {
                            $('td', row).eq(5).wrapInner('<span class="badge bg-warning"></span>');
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
                    var status = {};
                    var city = {};
                    var offer = {};

                    // get input values 
                    $("input:checkbox[name=status]:checked").each(function(i, e) {
                        status[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=city]:checked").each(function(i, e) {
                        city[$(this).val()] = e.checked;
                    });
                    $("input:checkbox[name=offer]:checked").each(function(i, e) {
                        offer[$(this).val()] = e.checked;
                    });

                    if ($("#min_price").val()) {
                        paramsinput['min_price'] = $("#min_price").val();
                    }
                    if ($("#max_price").val()) {
                        paramsinput['max_price'] = $("#max_price").val();
                    }
                    if ($("#start_date").val()) {
                        paramsinput['start_date'] = $("#start_date").val();
                    }
                    if ($("#end_date").val()) {
                        paramsinput['end_date'] = $("#end_date").val();
                    }
                    // convert object to string param and concatinate 
                    if (!$.isEmptyObject(status)) {
                        var status_param = $.param(status);
                        paramschecked = status_param + '&';
                    }
                    if (!$.isEmptyObject(city)) {
                        var city_param = $.param(city);
                        paramschecked = paramschecked + city_param + '&';

                    }
                    if (!$.isEmptyObject(offer)) {
                        var offer_param = $.param(offer);
                        paramschecked = paramschecked + offer_param + '&';
                    }

                    var paramsinput_string = $.param(paramsinput);
                    var params = 'params=true&' + paramschecked + paramsinput_string;
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
