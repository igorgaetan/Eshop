<x-layaout>

     <!-- Nouvelle tontine-->
     <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Ajout d'une nouvelle tontine</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{route('tontine.store',["clientCarte"=>$clientCarte])}}" method="post">
                @csrf


                <div class="form-group mb-3">
                    <label
                      for="montant"
                      >Montant
                    </label>
                    <input
                      name="montant"
                      type="number"
                      class="form-control validate"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label for="commentaire" class="col-form-label">Commentaire:</label>
                    <textarea class="form-control" id="message-text" name="commentaire" required></textarea>
                  </div>
                  <div class="row">
                    <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="action"
                          >Action
                        </label>
                        <select class="form-select" aria-label="Default select example" name="action">
                          <option selected value="1">Depot</option>
                      </select>
                      </div>
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="validite"
                          >Validité
                        </label>
                        <select class="form-select" aria-label="Default select example" name="validite">
                            <option selected value="1">Valide</option>
                            <option  value="0">Invalide</option>

                        </select>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
            </div>
          </div>
        </div>
    </div>


    <!-- tontine show-->
    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Tontine NO <span class="fw-bold" id="id_fac"> </span> </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="details-tontine">

                  <div class="form-group mb-3">
                    <label
                      for="montant"
                      >Montant
                    </label>
                    <input
                      name="montant"
                      type="number"
                      class="form-control validate"
                      disabled
                    />
                  </div>
                  <div class="mb-3">
                    <label for="commentaire" class="col-form-label">Commentaire:</label>
                    <textarea class="form-control" id="message-text" name="commentaire"></textarea>
                  </div>
                  <div class="row">
                    <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="action"
                          >Action
                        </label>
                        <select class="form-select" aria-label="Default select example" name="action" disabled>
                          <option selected value="1">Depot</option>
                          <option  value="0">Retrait</option>

                      </select>
                      </div>
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="validite"
                          >Validité
                        </label>
                        <select class="form-select" aria-label="Default select example" name="validite" disabled>
                            <option selected value="1">Valide</option>
                            <option  value="0">Invalide</option>

                        </select>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Terminer</button>
            </div>
          </div>
        </div>
    </div>

     <!-- Modal pour la date-->
     <div class="modal fade" id="date" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Selectionner un interval de temps</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <input type="hidden" name="search" value="interval">
                <div class="modal-body row">
                        <input type="hidden" name="search" value="interval"/>
                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                            <label
                            for="date1"
                            >Debut
                            </label>
                            <input
                            name="date1"
                            type="date"
                            class="form-control validate"
                            required
                            />
                        </div>
                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                            <label
                            for="prix"
                            >Fin
                            </label>
                            <input

                            name="date2"
                            type="date"
                            class="form-control validate"
                            required
                            />
                        </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
        </form>
        </div>
        </div>
    </div>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Client Matr. {{$clientCarte->matr}}</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Client</li>
                <li class="breadcrumb-item active">{{$clientCarte->matr}}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <img src="{{asset("images/profile-img.jpeg")}}" alt="Profile" class="rounded-circle">
                    <h2>{{$clientCarte->matr}}</h2>
                    <h3>
                        {{$clientCarte->nom}}
                    </h3>

                    </div>
                </div>

            </div>

            <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                    <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Général</button>
                    </li>

                    <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier</button>
                    </li>

                    <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tontines">Tontines</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#lignesCarte">Lignes Carte</button>
                    </li>

                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">

                        <h5 class="card-title">Details</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">

                            @foreach ($errors->all() as $error)
                            {{$error}}
                            @endforeach

                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Matricule</div>
                            <div class="col-lg-9 col-md-8">{{$clientCarte->matr}}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Nom</div>
                            <div class="col-lg-9 col-md-8">{{$clientCarte->nom}}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Sexe</div>
                            <div class="col-lg-9 col-md-8">
                                @if ($clientCarte->sexe)
                                    Homme
                                @else
                                    Femme
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Phone</div>
                            <div class="col-lg-9 col-md-8">{{$clientCarte->mobile}}
                                @if($clientCarte->whatsapp)
                                    <span class="text-success fw-bold">Whatsapp</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Ville</div>
                            <div class="col-lg-9 col-md-8">
                               {{$clientCarte->ville->libelle}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Addresse</div>
                            <div class="col-lg-9 col-md-8">
                               {{$clientCarte->addresse}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Date Naissance</div>
                            <div class="col-lg-9 col-md-8">
                               @if($clientCarte->dateNaiss)
                                  @php
                                    $date = DateTime::createFromFormat('Y-m-d', $clientCarte->dateNaiss);
                                  @endphp

                                 {{$date->format('d-m-Y')}}
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Points</div>
                            <div class="col-lg-9 col-md-8">
                               {{formateur($clientCarte->point)}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Tontine</div>
                            <div class="col-lg-9 col-md-8">
                               {{formateur($clientCarte->montantTontine)}} {{config('app.device')}}
                            </div>
                        </div>

                        @if(isset($bonAchat))

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Bon disponible</div>
                            <div class="col-lg-9 col-md-8">
                               {{formateur($bonAchat->montantGlobal)}} {{config('app.device')}}
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Date de creation</div>
                            <div class="col-lg-9 col-md-8">
                               {{$clientCarte->created_at->format('d-m-Y')}}
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                        <!-- Profile Edit Form -->
                        <form action="{{route('client.update',['clientCarte'=>$clientCarte])}}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea
                                    class="form-control validate"
                                    rows="1"
                                    name="nom"
                                    >{{$clientCarte->nom}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="about" class="col-md-4 col-lg-3 col-form-label">Date Naissance</label>
                                <div class="col-md-8 col-lg-9">
                                    <input
                                        name="dateNaiss"
                                        type="date"
                                        class="form-control validate"
                                        value={{$clientCarte->dateNaiss}}
                                        required
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Sexe</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" aria-label="Default select example" name='sexe'>
                                        <option selected value="{{$clientCarte->sexe}}">
                                            @if($clientCarte->sexe)
                                            HOMME
                                            @else
                                            FEMME
                                            @endif
                                        </option>
                                        <option value="1">HOMME</option>
                                        <option value="0">FEMME</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Ville</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" aria-label="Default select example" name="ville_id">

                                        @foreach ($villes as $ville)
                                        @if ($ville==$clientCarte->ville)
                                            <option selected value="{{$ville->id}}">{{$ville->libelle}}</option>
                                        @else
                                            <option value="{{$ville->id}}">{{$ville->libelle}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Mobile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input
                                        value={{$clientCarte->mobile}}
                                        name="mobile"
                                        type="text"
                                        class="form-control validate"

                                        />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Whatsapp</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" aria-label="Default select example" name='whatsapp'>
                                        <option selected value="{{$clientCarte->whatsapp}}">
                                            @if($clientCarte->whatsapp)
                                            Oui
                                            @else
                                            Non
                                            @endif
                                        </option>
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Adresse</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea
                                    class="form-control validate"
                                    rows="2"
                                    name="addresse"
                                    ></textarea>
                                </div>
                            </div>


                            <div class="text-center">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </form><!-- End Profile Edit Form -->

                    </div>

                    <div class="tab-pane fade pt-3" id="tontines">

                        <div class="filter text-end">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li>
                                <form>
                                    <button class="dropdown-item"type="submit">This year</button>
                                </form>

                            </li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#date">Choisir une periode</a></li>
                            </ul>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center align-middle" >Numero</th>
                                    <th scope="col" class="text-center align-middle" >Montant</th>
                                    <th scope="col" class="text-center align-middle" >Validite</th>
                                    <th scope="col" class="text-center align-middle" >Action</th>
                                    <th scope="col" class="text-center align-middle" >Caissier</th>
                                    <th scope="col" class="text-center align-middle" >Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tontines as $tontine)
                                    <tr>

                                        <td class="text-center align-middle"><button class="btn btn1 text-info fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">{{$tontine->id}}</button></td>
                                        <td class="text-center align-middle">{{formateur($tontine->montant)}}</td>
                                        <td class="text-center align-middle">
                                            @if($tontine->validite)
                                            Valide
                                            @else
                                            Invalide
                                            @endif

                                        </td>
                                        <td class="text-center align-middle">
                                            @if($tontine->action)
                                                Depot
                                            @else
                                                Paiement
                                            @endif
                                        </td>
                                        <input type="hidden" name="id" value="{{$tontine->id}}"/>
                                        <input type="hidden" name="montant" value="{{$tontine->montant}}"/>
                                        <input type="hidden" name="validite" value="{{$tontine->validite}}"/>
                                        <input type="hidden" name="action" value="{{$tontine->action}}"/>
                                        <input type="hidden" name="commentaire" value="{{$tontine->commentaire}}"/>
                                        <input type="hidden" name="user" value="{{$tontine->user->nomGest}}"/>
                                        <td class="text-center align-middle">{{$tontine->user->nomGest}}</td>
                                        <td class="text-center align-middle">{{substr($tontine->created_at,0,10)}}</td>


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>


                        <!-- table container -->
                        <button class="btn btn-primary mb-3 w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Nouvelle tontine
                        </button>

                    </div>

                    <div class="tab-pane fade pt-3" id="lignesCarte">

                        <div class="filter text-end">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li>
                                <form>
                                    <button class="dropdown-item"type="submit">This year</button>
                                </form>

                            </li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#date">Choisir une periode</a></li>
                            </ul>
                        </div>

                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center align-middle" >Facture</th>
                                <th scope="col" class="text-center align-middle" >Montant</th>
                                <th scope="col" class="text-center align-middle" >Point</th>
                                <th scope="col" class="text-center align-middle" >Type</th>
                                <th scope="col" class="text-center align-middle" >Date</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($lignesCarte as $ligneCarte)
                                <tr>
                                    @php
                                        $facture=$ligneCarte->facture;
                                    @endphp
                                    <td  class="text-center align-middle"><a href="{{route('facture.edit',['facture'=>$facture])}}">{{$facture->id}}</a></td>
                                    <td  class="text-center align-middle">{{formateur($ligneCarte->montantFac)}}</td>
                                    <td  class="text-center align-middle">{{formateur($ligneCarte->point)}}</td>
                                    <td  class="text-center align-middle">
                                        @if($facture->paiementValid)
                                            <span class="badge bg-success">
                                                @if ($facture->typeFac==0)
                                                    Cash

                                                @elseif ($facture->typeFac==1)
                                                    Tontine

                                                @elseif ($facture->typeFac==2)
                                                    Bon achat

                                                @elseif ($facture->typeFac==3)
                                                    OM

                                                @elseif ($facture->typeFac==4)
                                                    Momo

                                                @else
                                                    Autre
                                                @endif
                                            </span>

                                        @else
                                        <span class="badge bg-warning">
                                            @if ($facture->typeFac==0)
                                            Cash

                                            @elseif ($facture->typeFac==1)
                                                Tontine

                                            @elseif ($facture->typeFac==2)
                                                Bon achat

                                            @elseif ($facture->typeFac==3)
                                                OM

                                            @elseif ($facture->typeFac==4)
                                                Momo

                                            @else
                                                Autre
                                            @endif
                                        </span>

                                        @endif
                                    </td>
                                    <td  class="text-center align-middle">{{$ligneCarte->created_at->format('d-m-Y')}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>


                    <!-- table container -->

                    <a class="btn btn-primary mb-3 w-100" href='{{route('creerBonAchat',['clientCarte'=>$clientCarte])}}'>
                        Convertir en bon d'achat
                    </a>

                    </div>


                </div><!-- End Bordered Tabs -->

                </div>
            </div>

            </div>
        </div>
        </section>

    </main><!-- End #main -->


    <script>
        function  showTontineDetail(event){
          const btn = event.target;
          const tr = ((btn.parentElement).parentElement);

          const div = document.getElementById('details-tontine');

          div.querySelector('input[name="montant"]').value=tr.querySelector('input[name="montant"]').value;
          div.querySelector('select[name="action"]').value=tr.querySelector('input[name="action"]').value;

          div.querySelector('select[name="validite"]').value=tr.querySelector('input[name="validite"]').value;

          div.querySelector('textarea[name="commentaire"]').value=tr.querySelector('input[name="commentaire"]').value;

          const span = document.getElementById("id_fac");
          span.innerHTML=tr.querySelector('input[name="id"]').value;
        }

            const submitButtons = document.querySelectorAll('.btn1');
        submitButtons.forEach(function(submitButton, index) {
        submitButton.addEventListener('click', showTontineDetail); // Attach the click event listener
            });
    </script>
</x-layaout>
