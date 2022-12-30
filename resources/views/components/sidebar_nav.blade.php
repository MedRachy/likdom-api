<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Administration</div>
            <a class="nav-link" href="{{ route('admin.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Tableau de bord
            </a>
            {{-- Reservations --}}
            {{-- <div class="sb-sidenav-menu-heading">Réservations</div> --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                Réservations
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('admin.reserv.index') }}">Liste</a>
                    {{-- <a class="nav-link" href="{{ route('admin.reserv.search') }}">Recherche</a> --}}
                    <a class="nav-link" href="{{ route('admin.reserv.create') }}">Ajouter</a>
                </nav>
            </div>
            {{-- Abonnements --}}
            {{-- <div class="sb-sidenav-menu-heading">Abonnements</div> --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAbonmt"
                aria-expanded="false" aria-controls="collapseAbonmt">
                <div class="sb-nav-link-icon"><i class="fas fa-th-list"></i></div>
                Abonnements
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseAbonmt" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('admin.abonmt.index') }}">Liste</a>
                    <a class="nav-link" href="{{ route('admin.abonmt.create') }}">Ajouter</a>
                </nav>
            </div>
            {{-- Employees --}}
            {{-- <div class="sb-sidenav-menu-heading">Employées</div> --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmply"
                aria-expanded="false" aria-controls="collapseEmply">
                <div class="sb-nav-link-icon"><i class="far fa-id-card"></i></div>
                Employées
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseEmply" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('admin.emply.index') }}">Liste</a>
                    <a class="nav-link" href="{{ route('admin.emply.create') }}">Ajouter</a>
                </nav>
            </div>
            {{-- Users --}}
            {{-- <div class="sb-sidenav-menu-heading">Users</div> --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers"
                aria-expanded="false" aria-controls="collapseUsers">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                Utilisateurs
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">Liste</a>
                    <a class="nav-link" href="{{ route('admin.users.admins') }}">Administrateurs</a>
                    <a class="nav-link" href="{{ route('admin.users.create') }}">Ajouter</a>
                </nav>
            </div>
            {{-- Contracts --}}
            {{-- <div class="sb-sidenav-menu-heading">Contracts</div> --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseContracts"
                aria-expanded="false" aria-controls="collapseContracts">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                Contrats
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseContracts" aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('admin.contracts.index') }}">Liste</a>

                    <a class="nav-link" href="{{ route('admin.contracts.create') }}">Ajouter</a>
                </nav>
            </div>
            {{-- charts --}}
            <a class="nav-link" href="{{ route('admin.charts') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Graphiques
            </a>

        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Connecté en tant que :</div>
        Super admin
    </div>
</nav>
