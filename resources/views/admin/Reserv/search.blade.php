@extends('layouts.admin')
@section('content')

    <h3 class="mt-4"><a class="text-decoration-none" href="{{ route("admin.index")}}"><i class="fas fa-chevron-left"></i></a> </h3>
      <div class="row">
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card  border-success shadow-sm p-3  bg-white rounded">
            <h5 class="card-header">Réservations valider  <span class="badge bg-success float-end">Total : {{ $count }}</span> </h5>
            <div class="card-body">

              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Ref</th>
                      <th scope="col">Service</th>
                      <th scope="col">Ville</th>
                      <th scope="col">Date</th>
                      <th scope="col">Heure</th>
                      <th scope="col">Passage</th>
                      <th scope="col">Prix</th>
                    </tr>
                  </thead>
                  <tbody>
                    @isset($reservations)
                        @foreach ($reservations as $reserv )
                        
                        <tr
                    
                        @isset($reserv->abonnement)
                        class="table-info"
                        @endisset
                        >
                            <th scope="row">{{ $reserv->id }}</th>
                            <td>{{ $reserv->service }}</td>
                            <td>{{ $reserv->ville }}</td>
                            <td>{{ $reserv->date_passage }}</td>
                            <td>{{ $reserv->heure_passage }}</td>
                            <td>
                            @isset($reserv->abonnement)
                                Abonmt : {{ $reserv->abonnement->id }}
                                @else
                                unique
                            @endisset
                            </td>
                            <td>{{ $reserv->prix }}</td>
                            <td><a href="{{ route("admin.reserv.show",$reserv->id) }}">Détails</a></td>                     
                        </tr>                    
                        @endforeach                        
                    @endisset

                  </tbody>
              </table>
              </div>

            </div>
          </div>
        </div>
      </div>

@endsection