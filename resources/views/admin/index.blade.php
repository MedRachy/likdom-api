@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="mt-4">Tableau de bord</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active">index</li>
            </ol>
        </div>
        <div class="col-md-6">
            <h3><span class="badge bg-primary float-end">Users inscrit : {{ $total_users }}</span></h3>
        </div>
    </div>
    {{-- states --}}
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4  text-center">
                <div class="card-body">
                    <p class="m-0 fs-1 fw-bold">{{ $reservs_today }}</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#reservations_today"> Réservations de la journée </a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 text-center">
                <div class="card-body">
                    <p class="m-0 fs-1 fw-bold">{{ $reserv_abonmt_pending }}</p>
                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#reservations_en_attente">En attente de validation</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 text-center">
                <div class="card-body">
                    <p class="m-0 fs-1 fw-bold">{{ $abonmts_today }}</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#abonnements_active">Abonnements active</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white mb-4  text-center">
                <div class="card-body">
                    <p class="m-0 fs-1 fw-bold">{{ $employees_today }}</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#employees_planifier"> Employées planifier </a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    {{-- Reservations en attente --}}
    <div class="row" id="reservations_en_attente">
        <div class="col-md-12">
            <div class="card  border-warning shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Réservations <span class="badge bg-warning">En attente</span> </h5>
                <div class="card-body">
                    <h6 class="card-title">Liste des nouvelles réservations en attente de validation </h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reserv)
                                    <tr>
                                        <th scope="row">{{ $reserv->id }}</th>
                                        <td>{{ $reserv->service }}</td>
                                        <td>{{ $reserv->city }}</td>
                                        <td>{{ $reserv->start_date }}</td>
                                        <td>{{ $reserv->start_time }}</td>
                                        <td>{{ $reserv->price }}</td>
                                        <td><a href="{{ route('admin.reserv.show', $reserv->id) }}"
                                                class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.reserv.edit', $reserv->id) }}"
                                                class="edit btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Abonnement en attente --}}
    <div class="row mt-4" id="abonnements_en_attente">
        <div class="col-md-12">
            <div class="card border-warning shadow-sm p-3 bg-white rounded">
                <h5 class="card-header">Abonnements en attente de validation <span class="badge bg-warning">En
                        attente</span>
                </h5>
                <div class="card-body">
                    <h6 class="card-title">Abonnements </h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Offre</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Date debut</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($abonnements as $sub)
                                    <tr>
                                        <th scope="row">{{ $sub->id }}</th>

                                        <td>{{ $sub->offer->name }}</td>
                                        <td>{{ $sub->city }}</td>
                                        <td>{{ $sub->start_date }}</td>
                                        <td>{{ $sub->price }}</td>
                                        <td>
                                            <a href="{{ route('admin.abonmt.show', $sub->id) }}"
                                                class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.abonmt.edit', $sub->id) }}"
                                                class="edit btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Today reservations --}}
    <div class="row mt-4" id="reservations_today">
        <div class="col-md-12">
            <div class="card  border-success shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Réservations de la journée <span class="badge bg-success">Valider</span> </h5>
                <div class="card-body">
                    <h6 class="card-title">Réservations</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($today_reservations as $reserv)
                                    <tr>
                                        <th scope="row">{{ $reserv->id }}</th>
                                        <td>{{ $reserv->service }}</td>
                                        <td>{{ $reserv->city }}</td>
                                        <td>{{ $reserv->start_date }}</td>
                                        <td>{{ $reserv->start_time }}</td>
                                        <td>{{ $reserv->price }}</td>
                                        <td>
                                            <a href="{{ route('admin.reserv.show', $reserv->id) }}"
                                                class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.reserv.edit', $reserv->id) }}"
                                                class="edit btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    {{-- Abonnement active --}}
    <div class="row mt-4" id="abonnements_active">
        <div class="col-md-12">
            <div class="card border-success shadow-sm p-3 bg-white rounded">
                <h5 class="card-header">Abonnements active de la journée <span class="badge bg-success">Valider</span>
                </h5>
                <div class="card-body">
                    <h6 class="card-title">Abonnements </h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Offre</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($today_abonnements as $sub)
                                    <tr>
                                        <th scope="row">{{ $sub->id }}</th>

                                        <td>{{ $sub->offer->name }}</td>
                                        <td>{{ $sub->city }}</td>
                                        <td>
                                            @foreach ($sub->passages as $passage)
                                                @if ($passage['day'] == $todayName)
                                                    {{ $passage['time'] }}
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>{{ $reserv->price }}</td>
                                        <td>
                                            <a href="{{ route('admin.abonmt.show', $reserv->id) }}"
                                                class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.abonmt.edit', $reserv->id) }}"
                                                class="edit btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Employees planifier --}}
    <div class="row mt-4" id="employees_planifier">
        <div class="col-md-12">
            <div class="card shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Employées planifier pour la journée</h5>
                <div class="card-body">
                    <h6 class="card-title">Réservations</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Reserv</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Tel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($today_reservations as $reserv)
                                    @foreach ($reserv->employees as $employee)
                                        <tr>
                                            <td>{{ $employee->id }}</td>
                                            <td><a
                                                    href="{{ route('admin.reserv.show', $reserv->id) }}">{{ $reserv->id }}</a>
                                            </td>
                                            <td>{{ $employee->last_name }}</td>
                                            <td>{{ $employee->first_name }}</td>
                                            <td>{{ $employee->adress }}</td>
                                            <td>{{ $employee->city }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td><a href="{{ route('admin.emply.show', $employee->id) }}"
                                                    class="edit btn btn-primary btn-sm" target="_blank"><i
                                                        class="fas fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h6 class="card-title"> Abonnements</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Reserv</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Tel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($today_abonnements as $sub)
                                    @foreach ($sub->employees as $employee)
                                        <tr>
                                            <td>{{ $employee->id }}</td>
                                            <td><a
                                                    href="{{ route('admin.abonmt.show', $sub->id) }}">{{ $sub->id }}</a>
                                            </td>
                                            <td>{{ $employee->last_name }}</td>
                                            <td>{{ $employee->first_name }}</td>
                                            <td>{{ $employee->adress }}</td>
                                            <td>{{ $employee->city }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td><a href="{{ route('admin.emply.show', $employee->id) }}"
                                                    class="edit btn btn-primary btn-sm" target="_blank"><i
                                                        class="fas fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
