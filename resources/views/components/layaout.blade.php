<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <link rel="icon" href="{{asset('logo.jpg')}}" type="image/jpg">

  <title>{{config('app.entreprise')}}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">



    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">


  <!-- Ajax-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>

<style>
  body {
      font-family: 'Montserrat','Arial', sans-serif; /* Remplacez 'Arial' par la police de votre choix */
      font-size: 15px; /* Taille de police par défaut */
      line-height: 1.5; /* Hauteur de ligne par défaut */
  }
</style>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center" style="background-color: #FF0000;">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="#" alt="">
        <span class="d-none d-lg-block text-white">{{config('app.entreprise')}}</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn text-white"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{asset("images/profile-img.jpeg")}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-white">{{auth()->user()->nomGest}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="background-color: #FF0000;">
            <li class="dropdown-header">
              <h6 class="text-white">{{auth()->user()->nomGest}}</h6>
              <span class="text-white">
                @if (auth()->user()->typeGest==1)
                Caissier
                @elseif (auth()->user()->typeGest==0)
                Administrateur
                @elseif (auth()->user()->typeGest==2)
                Magasinier
                @elseif (auth()->user()->typeGest==3)
                Vendeur
                @elseif (auth()->user()->typeGest==4)
                Auditeur
                @elseif (auth()->user()->typeGest==5)
                Financier
                @endif
              </span>
            </li>
            <li class="text-white">
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('user.view_profile',["user"=>auth()->user()])}}">
                <i class="bi bi-person"></i>
                <span class="text-white">Mon Compte</span>
              </a>
            </li>
            <li >
              <hr class="text-white dropdown-divider">
            </li>


            <li>
              <hr class="text-white dropdown-divider">
            </li>




            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span class="text-white">Se deconnecter</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      @can('voir les finances')
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{route('index')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>
      @endcan

      @can('see category')
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{route('categorie.index')}}">
            <i class="bi bi-card-list"></i>
            <span>Categories</span>
          </a>
        </li>
      @endcan

      @can('see orders')

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#commandes-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-bag-check"></i><span>Commandes</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="commandes-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{route('commande.index')}}">
                <i class="bi bi-circle"></i><span>Liste</span>
              </a>
            </li>

            <li>
              <a href="{{route('transporteurList')}}">
                <i class="bi bi-circle"></i><span>Transporteur</span>
              </a>
            </li>
          </ul>
        </li>
      @endcan




      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#produits-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-box-seam"></i><span>Produits</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="produits-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('produits.index')}}">
              <i class="bi bi-circle"></i><span>Tous</span>
            </a>
          </li>
          <li>
            <a href="{{route('produits.search')}}">
              <i class="bi bi-circle"></i><span>Rechercher un produit</span>
            </a>
          </li>
          @can('edit, create products')
            <li>
              <a href="{{route('produits.create')}}">
                <i class="bi bi-circle"></i><span>Nouveau</span>
              </a>
            </li>
          @endcan
          @canany(['voir  fiche complete produit', 'voir les finances'])
            <li>
              <a href="{{route('produits.audit')}}">
                <i class="bi bi-circle"></i><span>Auditer</span>
              </a>
            </li>
          @endcanany

        </ul>
      </li>


      @can('see daily invoices')
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#factures-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-receipt"></i><span>Factures</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="factures-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{route('facture.index')}}">
                <i class="bi bi-circle"></i><span>Tous</span>
              </a>
            </li>
            <li>
                <a href="{{route('facture.index2')}}">
                  <i class="bi bi-circle"></i><span>En attente</span>
                </a>
              </li>
            @can('create and edit invoices')
              <li>
                <a href="{{route('newFacture')}}">
                  <i class="bi bi-circle"></i><span>Nouveau</span>
                </a>
              </li>
            @endcan

          </ul>
        </li>
      @endcan


      @can('voir les cartes clients')
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#clients-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-people"></i><span>Clients</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="clients-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{route('index.client')}}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Liste</span>
              </a>
            </li>
            <li>
              <a href="{{route('client.create')}}">
                <i class="bi bi-circle"></i><span>Nouveau</span>
              </a>
            </li>
             <li>
              <a href="{{route('tontine.index')}}">
                <i class="bi bi-circle"></i><span>Tontines</span>
              </a>
            </li>
          </ul>
        </li>
      @endcan

      @can('create and edit users')

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#utilateurs-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-person-badge"></i><span>Gestion Utilisateurs</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="utilateurs-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{route('equipe.index')}}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Liste</span>
              </a>
            </li>
            <li>

              <a href="{{route('user.create')}}">
                <i class="bi bi-circle"></i><span>Nouveau</span>
              </a>
            </li>
          </ul>
        </li>

      @endcan

    </ul>

  </aside><!-- End Sidebar-->

  {{ $slot }}
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">


  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


</body>

    <!-- Vendor JS Files -->
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
    <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>

</html>
