@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="mt-4">Graphiques</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active">Graphiques</li>
            </ol>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm float-end">
                <label class="input-group-text" for="date_debut">Date début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut">
                <label class="input-group-text" for="date_fin">Date fin</label>
                <input type="date" class="form-control" id="date_fin" name="date_fin">
                <button id="bntdate" class="btn btn-primary">Afficher</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Nombre de réservations par jour
                </div>
                <div class="card-body"><canvas id="reservChart" width="100%" height="30"></canvas></div>
                {{-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> --}}
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-chart-bar me-1"></i>
                        Données par mois
                    </div>
                    <div class="input-group input-group-sm" style="width: 160px;">
                        <select class="form-select" id="selectyear" name="year" aria-label="select year">
                            <option value="2022-01-01">2022</option>
                            <option value="2023-01-01" selected>2023</option>
                            <option value="2024-01-01">2024</option>
                            <option value="2025-01-01">2025</option>
                            <option value="2026-01-01">2026</option>
                            <option value="2027-01-01">2027</option>
                        </select>
                        <button id="btnselectyear" class="btn btn-primary" type="button">Afficher</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"><canvas id="userChart" width="100%" height="70"></canvas></div>
                        <div class="col-md-6"><canvas id="reservYearChart" width="100%" height="70"></canvas></div>
                    </div>

                </div>
                {{-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Nombre de réservations par service
                </div>
                <div class="card-body"><canvas id="serviceChart" width="100%" height="50"></canvas></div>
                {{-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> --}}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Nombre d'abonnements par offre
                </div>
                <div class="card-body"><canvas id="offerChart" width="100%" height="50"></canvas></div>
                {{-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> --}}
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"
            integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {

                var url = './dataSearch';
                var query = '';
                // configs
                const configbarR = {
                    type: 'bar',
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };
                const configbarS = {
                    type: 'bar',
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };
                const configbarU = {
                    type: 'bar',
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };
                const configline = {
                    type: 'line',
                    options: {}
                };
                // init charts
                const chartService = new Chart(document.getElementById('serviceChart'), configbarS);
                const chartOffer = new Chart(document.getElementById('offerChart'), configbarS);
                const chartReserv = new Chart(document.getElementById('reservChart'), configline);
                const chartUser = new Chart(document.getElementById('userChart'), configbarU);
                const chartReservYear = new Chart(document.getElementById('reservYearChart'), configbarR);
                // get first load
                $.get(url, function(data) {
                    dateUpdate(data);
                    yearUpdate(data);
                });

                $("#bntdate").click(function() {
                    query = getdates();
                    url = './dataSearch?' + query;
                    $.get(url, function(data) {
                        dateUpdate(data);
                    });
                });

                $("#btnselectyear").click(function() {
                    query = 'year=' + $("#selectyear").val();
                    url = './dataSearch?' + query;

                    $.get(url, function(data) {
                        yearUpdate(data);
                    });
                });


                function dateUpdate(data) {
                    // reserv
                    var datareserv = {
                        datasets: [{
                                label: 'Réservations',
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: data.dataReserv
                            },
                            {
                                label: 'Abonnements',
                                backgroundColor: 'rgb(255, 193, 7)',
                                borderColor: 'rgb(255, 193, 7)',
                                data: data.dataSub
                            }
                        ]
                    };
                    chartReserv.data = datareserv;
                    chartReserv.update();
                    // service
                    var dataservice = {
                        datasets: [{
                            label: 'Reservations',
                            backgroundColor: 'rgb(255, 99, 132)',
                            data: data.dataService
                        }]
                    };
                    chartService.data = dataservice;
                    chartService.update();
                }

                function yearUpdate(data) {
                    // users
                    var datausers = {
                        datasets: [{
                            label: 'Utilisateurs',
                            backgroundColor: 'rgb(54 162 235)',
                            data: data.dataUsers
                        }]
                    };
                    chartUser.data = datausers;
                    chartUser.update();
                    // reservs
                    var dataReservYear = {
                        datasets: [{
                                label: 'Réservations',
                                backgroundColor: 'rgb(255, 99, 132)',
                                data: data.dataReservYear
                            },
                            {
                                label: 'Abonnements',
                                backgroundColor: 'rgb(255, 193, 7)',
                                data: data.dataSubYear
                            }
                        ]
                    };
                    chartReservYear.data = dataReservYear;
                    chartReservYear.update();
                }

                function getdates() {
                    var paramsinput = {};
                    if ($("#date_debut").val()) {
                        paramsinput['date_debut'] = $("#date_debut").val();
                    }
                    if ($("#date_fin").val()) {
                        paramsinput['date_fin'] = $("#date_fin").val();
                    }
                    var params = $.param(paramsinput);
                    // console.log(params);
                    return params;
                }

            })
        </script>
    @endpush
@endsection
