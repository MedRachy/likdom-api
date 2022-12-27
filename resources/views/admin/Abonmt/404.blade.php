@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="alert alert-danger d-flex align-items-center" role="alert" style="margin-top: 100px;">
                <i class="fas fa-info-circle mx-2"></i>
                Oops ! Abonnement n'existe pas, essayer de chercher par d'autre critaire depuis la
                <a href="{{ route('admin.abonmt.index') }}" class="alert-link px-2"> Liste des abonnements</a>
            </div>
        </div>
    </div>
@endsection
