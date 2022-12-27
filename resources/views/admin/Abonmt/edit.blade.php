@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="mt-4">Abonnements</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.abonmt.index') }}">liste</a> </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.abonmt.show', $sub->id) }}">abonnement</a> </li>
                <li class="breadcrumb-item active">modifier</li>
            </ol>
        </div>
        <div class="col-md-6">
            <a class="float-end btn btn-primary btn-sm text-decoration-none"
                href="javascript:form_submit();">Enregistrer</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Abonnement
                    @switch($sub->status)
                        @case('valid')
                            <span class="badge bg-success">Valider</span>
                        @break

                        @case('pending')
                            <span class="badge bg-warning">En attente</span>
                        @break

                        @case('cancel')
                            <span class="badge bg-danger">Annuler</span>
                        @break

                        @default
                    @endswitch
                </h5>
                <div class="card-body">

                    @if ($sub->confirmed)
                        <h6 class="card-title "> abonnement confirmer </h6>
                    @else
                        <h6 class="card-title bg-danger p-2" style="color: white"> abonnement pas encore confirmer par le
                            client</h6>
                    @endif

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between active ">
                            <div>
                                <h5 class="text-bold">Offre</h5>
                                <p class="mb-1">{{ $sub->offer->name }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Date début</h5>
                                <p class="mb-1">{{ $sub->start_date }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Prix</h5>
                                <p class="mb-1">{{ $sub->price }} DH</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Passages</h5>
                                <ul>
                                    @foreach ($sub->passages as $passage)
                                        <li>{{ $passage['day'] }} : {{ $passage['time'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <h5 class="text-bold">Nbr heures</h5>
                                <p class="mb-1 text-center">{{ $sub->nbr_hours }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Nbr employees</h5>
                                <p class="mb-1 text-center">{{ $sub->nbr_employees }}</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Adresse</h5>
                                <p class="mb-1 text-center">{{ $sub->adress }}</p>

                            </div>
                            <div>
                                <h5 class="text-bold">Ville</h5>
                                <p class="mb-1 text-center">{{ $sub->city }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card  shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Employées disponible pour cette réservation</h5>
                <div class="card-body">
                    {{-- @isset($sub->Emp_selected)
                        <h6 class="card-title">Employée selectionner par le client : <span
                                class="bg-info fw-bold px-2">{{ $sub->Emp_selected }}</span> </h6>
                    @endisset --}}

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Tel</th>
                                    <th scope="col">Planing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="select_employees" method="POST"
                                    action="{{ route('admin.reserv.update', $sub->id) }}">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="edit_Emp_selected">
                                    {{-- employé déja attribué --}}
                                    @isset($sub->employees)
                                        @foreach ($sub->employees as $emp_reserv)
                                            <tr class="table-primary">
                                                <td>
                                                    <input checked class="form-check-input me-1" type="checkbox"
                                                        name="Emp_selected[]" value="{{ $emp_sub->id }}" aria-label="...">
                                                </td>
                                                <td>{{ $emp_sub->id }} </td>
                                                <td>{{ $emp_sub->nom }}</td>
                                                <td>{{ $emp_sub->prenom }}</td>
                                                <td>{{ $emp_sub->age }}</td>
                                                <td>{{ $emp_sub->adresse }}</td>
                                                <td>{{ $emp_sub->ville }}</td>
                                                <td>{{ $emp_sub->phone }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.emply.show', $emp_sub->id) }}" target="_blank"
                                                        class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    {{-- employées dispo --}}
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>
                                                <input class="form-check-input me-1" type="checkbox" name="Emp_selected[]"
                                                    value="{{ $employee->id }}" aria-label="...">
                                            </td>
                                            <td>{{ $employee->id }} </td>
                                            <td>{{ $employee->nom }}</td>
                                            <td>{{ $employee->prenom }}</td>
                                            <td>{{ $employee->age }}</td>
                                            <td>{{ $employee->adresse }}</td>
                                            <td>{{ $employee->ville }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.emply.show', $employee->id) }}" target="_blank"
                                                    class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            function form_submit() {
                let form = document.getElementById("select_employees");
                form.submit();
            }
        </script>
    @endpush

@endsection
