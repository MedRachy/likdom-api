@extends('layouts.admin')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="mt-4">Contrats</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contracts.index') }}">liste</a> </li>
                <li class="breadcrumb-item active">contrat</li>
            </ol>
        </div>
        <div class="col-md-6">
            {{-- @isset($contract->storage_path)
                <a class="float-end btn btn-outline-primary btn-sm text-decoration-none" href="">Voir contrat</a>
            @endisset --}}

            <form method="POST" action="{{ route('admin.contracts.generate') }}">
                @csrf
                <input type="hidden" name="contract_id" value="{{ $contract->id }}">
                <button class="float-end btn btn-primary btn-sm ">Voir contrat</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  border-info shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Contrat</h5>
                <div class="card-body">
                    {{-- <h4><span class="badge bg-info">45 Points</span></h4> --}}
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between active ">
                            <div>
                                <h5 class="text-bold">Manager</h5>
                                <p class="mb-1">{{ $contract->manager_name }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Entreprise</h5>
                                <p class="mb-1">{{ $contract->company_name }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Capital</h5>
                                <p class="mb-1">{{ $contract->capital }}</p>
                            </div>

                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">Ref utilisateur</h5>
                                <p class="mb-1 text-center">

                                    <a href="{{ route('admin.users.show', $contract->user_id) }}" target="_blank"
                                        class="edit btn btn-primary btn-sm">{{ $contract->user_id }} </a>
                                </p>
                            </div>
                            <div>
                                <h5 class="text-bold">Ref abonnement</h5>
                                <p class="mb-1 text-center">
                                    <a href="{{ route('admin.abonmt.show', $contract->subscription_id) }}" target="_blank"
                                        class="edit btn btn-primary btn-sm">{{ $contract->subscription_id }} </a>
                                </p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="text-bold">RC number</h5>
                                <p class="mb-1">{{ $contract->rc_number }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Adresse</h5>
                                <p class="mb-1">{{ $contract->adress }}</p>
                            </div>
                            <div>
                                <h5 class="text-bold">Ville</h5>
                                <p class="mb-1">{{ $contract->city }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
