@extends('layouts.admin')
@section('content')
   <div class="row">
       <div class="col-md-10 mx-auto">
            <div class="alert alert-danger d-flex align-items-center" role="alert" style="margin-top: 100px;">
                <i class="fas fa-info-circle mx-2"></i>
                Oops ! Reservation n'existe pas, essayer de chercher par d'autre critaire depuis la   
                <a href="{{ route('admin.reserv.index') }}" class="alert-link px-2"> Liste des reservations</a>
            </div>           
       </div>
   </div>
@endsection