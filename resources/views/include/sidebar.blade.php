<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
          {{-- <img src="img/logo/logo2.png"> --}}
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Tableau de bord</span></a>
      </li>
      <hr class="sidebar-divider">

     

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          {{-- <i class="far fa-fw fa-window-maximize"></i> --}}
          <span>Les élèves</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Bootstrap UI</h6> --}}
            <a class="collapse-item" href="{{route('eleves.index')}}">Liste des élèves</a>
            <a class="collapse-item" href="{{route('eleves.create')}}">Nouvel élève</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          {{-- <i class="fab fa-fw fa-wpforms"></i> --}}
          <span>Paiements</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Forms</h6> --}}
            <a class="collapse-item" href="{{route('paiements.index')}}">Liste des paiements</a>
            <a class="collapse-item" href="{{route('paiements.create')}}">Nouveau paiement</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          {{-- <i class="fas fa-fw fa-table"></i> --}}
          <span>Classes</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Tables</h6> --}}
            <a class="collapse-item" href="{{route('classe.index')}}">Liste des classes</a>
            <a class="collapse-item" href="{{route('classe.create')}}">Ajouter une classe</a>
          </div>
        </div>
      </li>
      {{-- <hr class="sidebar-divider"> --}}
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          {{-- <i class="fas fa-fw fa-columns"></i> --}}
          <span>Frais scolaires</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Example Pages</h6> --}}
            <a class="collapse-item" href="{{route('frais-scolaire.index')}}">Liste des frais scolaires</a>
            <a class="collapse-item" href="{{route('frais-scolaire.create')}}">Ajouter un frais scolaire</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePag" aria-expanded="true"
          aria-controls="collapsePag">
          {{-- <i class="fas fa-fw fa-columns"></i> --}}
          <span>Type de frais scolaire</span>
        </a>
        <div id="collapsePag" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Example Pages</h6> --}}
            <a class="collapse-item" href="{{route('type-paiement.index')}}">Liste des type de frais </a>
            <a class="collapse-item" href="{{route('type-paiement.create')}}">Ajouter un type de frais </a>
          </div>
        </div>
      </li>
      {{-- <div class="version" id="version-ruangadmin"></div> --}}
</ul>
