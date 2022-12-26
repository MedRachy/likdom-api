@extends('layouts.admin')
@section('content')
    <!-- Modal Supprimer -->
    <div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="ModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel3">Supprimer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="lead text-danger">ête vous sur de vouloir supprimer cette utilisateur</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteform" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button id="btndelete" type="submit" class="btn btn-danger">Supprimer</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="mt-4">Administrateurs</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active">liste</li>
            </ol>
        </div>
        <div class="col-md-6">
            <h3><span class="badge bg-primary float-end">Administrateurs : {{ $total_admins }}</span></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm p-3  bg-white rounded">
                <h5 class="card-header">Liste des administrateurs
                    <a class="float-end btn btn-primary btn-sm text-decoration-none"
                        href="{{ route('admin.users.create') }}">Ajouter</a>
                </h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ref</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Tel</th>
                                    <th scope="col">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>{{ $admin->role }}</td>
                                        <td>
                                            <button type="button" class="float-end btn btn-sm  btn-outline-danger"
                                                data-id="{{ $admin->id }}" data-bs-toggle="modal"
                                                data-bs-target="#ModalDelete">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
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
    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {

                $('#ModalDelete').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var adminID = button.data('id')
                    var modal = $(this)
                    var form = modal.find('#deleteform');
                    form.attr("action", "{{ url('admin/users/') }}" + "/" + adminID);
                    // console.log(form.attr('action'));
                })
            });
        </script>
    @endpush
@endsection
