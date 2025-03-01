<x-layaout>
    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Details du produit {{substr($produit->codePro,0,3)}}-{{substr($produit->codePro,3)}}</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
              <li class="breadcrumb-item">Produits</li>
              <li class="breadcrumb-item active">{{substr($produit->codePro,0,3)}}-{{substr($produit->codePro,3)}}  @if($produit->actif) <span class="badge bg-success">Disponible</span> @else <span class="badge bg-warning"> Pas disponible </span>  @endif</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @canany(['voir les finances','voir  fiche complete produit'])
              <div class="row">

                  <!-- Modal pour la date-->
                  <div class="modal fade" id="verticalycentered1" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title">Selectionner un interval de temps</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form>

                              <div class="modal-body row">

                                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                                          <label
                                          for="date1"
                                          >Debut
                                          </label>
                                          <input
                                          name="date1Fac"
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

                                          name="date2Fac"
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



                  <!-- Sales Card facture -->
                  <div class="col-xxl-4 col-md-6 ml-0">
                    <div class="card info-card sales-card">

                      <div class="filter w-100 text-end pe-4">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                          <li class="dropdown-header text-start">
                            <h6>Vendu</h6>
                          </li>
                          <li>
                              <form>
                                  <button class="dropdown-item btn" type="submit">Aujourd'hui</button>
                              </form>
                            </li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#verticalycentered1" type="submit">Choisir une periode</a></li>
                        </ul>
                      </div>

                      <div class="card-body">
                        <h5 class="card-title">Vendu<span>
                          |
                          @if(isset(request()->date1Fac) && isset(request()->date2Fac) )
                              Du {{request()->date1Fac}} Au {{request()->date2Fac}}
                          @else
                              Aujourd'hui
                          @endif
                      </span></h5>

                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle border p-2 bg-success opacity-50 d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-cart"></i>
                          </div>
                          <div class="ps-3">
                            <h6>{{$qte}}</h6>
                            <span class="text-success small pt-1 fw-bold">{{$nombreFac}}</span> <span class="text-muted small pt-2 ps-1">Factures</span>

                          </div>
                        </div>
                      </div>

                    </div>
                  </div><!-- End Sales Card -->

                  <!-- Capitals Card facture -->
                  <div class="col-xxl-4 col-md-6 ml-0">
                    <div class="card info-card sales-card">



                      <div class="card-body">
                        <h5 class="card-title">Capital<span>
                          |
                          @if(isset(request()->date1Fac) && isset(request()->date2Fac) )
                              Du {{request()->date1Fac}} Au {{request()->date2Fac}}
                          @else
                              Aujourd'hui
                          @endif
                        </span></h5>

                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle border p-2 bg-success opacity-50 d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-currency-dollar"></i>
                          </div>
                          <div class="ps-3">
                            <h6> {{formateur($capital)}} </h6>
                            <span class="text-success small pt-1 fw-bold"> en {{config('app.device')}} </span> <span class="text-muted small pt-2 ps-1"></span>

                          </div>
                        </div>
                      </div>

                    </div>
                  </div><!-- End Sales Card -->

                  <!-- Revenus Card facture -->
                  <div class="col-xxl-4 col-md-6 ml-0">
                    <div class="card info-card sales-card">


                      <div class="card-body">
                        <h5 class="card-title">Revenue<span>
                          |
                          @if(isset(request()->date1Fac) && isset(request()->date2Fac) )
                              Du {{request()->date1Fac}} Au {{request()->date2Fac}}
                          @else
                              Aujourd'hui
                          @endif
                        </span></h5>

                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle border p-2 bg-success opacity-50 d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-currency-dollar"></i>
                          </div>
                          <div class="ps-3">
                            <h6> {{formateur($recette)}} </h6>
                            <span class="text-success small pt-1 fw-bold"> en {{config('app.device')}} </span> <span class="text-muted small pt-2 ps-1"></span>

                          </div>
                        </div>
                      </div>

                    </div>
                  </div><!-- End Sales Card -->

                  <!-- montant net recu Card facture -->
                  <div class="col-xxl-4 col-md-6 ml-0">
                    <div class="card info-card sales-card">


                      <div class="card-body">
                        <h5 class="card-title">Net percu<span>
                          |
                          @if(isset(request()->date1Fac) && isset(request()->date2Fac) )
                              Du {{request()->date1Fac}} Au {{request()->date2Fac}}
                          @else
                              Aujourd'hui
                          @endif
                        </span></h5>

                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle border p-2 bg-success opacity-50 d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-currency-dollar"></i>
                          </div>
                          <div class="ps-3">
                            <h6> {{formateur($netPercu)}} </h6>
                            <span class="text-success small pt-1 fw-bold">
                              @if($recette>0)
                              {{round((1-$netPercu/$recette)*100,2)}}  % de remise
                              @else
                              0 % de remise
                              @endif
                            </span> <span class="text-muted small pt-2 ps-1"></span>

                          </div>
                        </div>
                      </div>

                    </div>
                  </div><!-- End Sales Card -->


              </div>
            @endcan


            <!-- Modal pour l'ajout de photo-->
            <div class="modal fade" id="verticalycentered3" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Ajouter une photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('produit.storePhoto',["produit"=>$produit]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="custom-file p-3">
                            <label for="formFile" class="form-label">Choisir un image</label>
                            <input class="form-control" name="photo" type="file" id="formFile">
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            <!-- Photo -->
            <div class="card" >

                <div class="card-body">
                  <h5 class="card-title">Photos</span></h5>
                  <div class="row">
                    @foreach ($produit->photos as $photo)
                      <div class="col-6 col-md-3 col-lg-2 me-1" style="height: 150px">

                          <img  src="{{asset($photo->lienPhoto)}}" class="h-100 w-100">
                          <form action="{{route('produit.deletePhoto',["photo"=>$photo])}}" method="POST" style="margin-top:-100px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                              <i class="bi bi-trash-fill"></i>
                            </button>
                          </form>

                      </div>
                    @endforeach

                  </div>

                  @can('edit, create products')
                    <div class="w-100 row">
                      <button data-bs-toggle="modal" data-bs-target="#verticalycentered3" class="btn btn-primary  text-white offset-md-8 offset-lg-9 col-md-4 col-lg-3">Ajouter une nouvelle photo</button>
                    </div>
                  @endcan
                </div>


            </div>






            <!-- Div de la liste des  factures-->
            @canany(['voir les finances','voir  fiche complete produit'])
              <div class="row">

                  <!-- Dernieres factures -->
                  <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                      <div class="filter w-100 text-end pe-2">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                          <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                          </li>
                          <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#verticalycenteredFactureList">Choisir un date</a></li>
                        </ul>
                      </div>

                      <div class="card-body">
                        <h5 class="card-title">Dernieres Factures <span>| </span></h5>

                        <table class="table table-borderless datatable">
                          <thead>
                            <tr>
                              <th scope="col" class="text-center">#Facture</th>
                              <th scope="col" class="text-center">Date</th>
                              <th scope="col" class="text-center">Quantité</th>
                              <th scope="col" class="text-center">Prix vente</th>

                              <th scope="col" class="text-center">Prix Achat</th>
                              <th scope="col" class="text-center">Paiement</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($lignesFacture as $ligne)
                                  <tr>
                                      <th scope="row" class="text-center"><a href="{{route('facture.edit',['facture'=>$ligne->facture])}}">#{{$ligne->facture->id}}</a></th>
                                      <td class="text-center">{{$ligne->updated_at->format('d-m-Y')}}</td>
                                      <td class="text-center">{{$ligne->qte}}</td>
                                      <td class="text-center">{{formateur($ligne->prix)}}</td>
                                      <td class="text-center">{{formateur($ligne->prixAchat)}}</td>
                                      <td class="text-center">
                                            @if ($ligne->facture->typeFac==0)
                                            <span class="badge bg-success">Cash</span>

                                            @elseif ($ligne->facture->typeFac==1)
                                            <span class="badge bg-primary">Tontine</span>

                                            @elseif ($ligne->facture->typeFac==2)
                                              <span class="badge bg-info">Bon achat</span>

                                            @elseif ($ligne->facture->typeFac==3)
                                              <span class="badge bg-secondary">OM</span>

                                            @elseif ($ligne->facture->typeFac==4)
                                              <span class="badge bg-light">Momo</span>

                                            @elseif ($ligne->facture->typeFac==5)
                                              <span class="badge bg-warning">Autre</span>
                                            @endif
                                      </td>
                                </tr>
                              @endforeach

                          </tbody>
                        </table>

                      </div>

                    </div>
                  </div><!-- End Recent Sales -->


                </div>


            @endcan

             <!-- Modal pour ajouter une taille-->
                <div class="modal fade" id="AjouterSize" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Ajouter une taille</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('produit.storeSize',['produit'=>$produit])}}" method="POST">

                            @csrf
                            <div class="form-group p-3">
                                <label
                                for="name"
                                >Valeur :
                                </label>
                                <input
                                id="name"
                                name="name"
                                type="text"
                                class="form-control validate"
                                />
                            </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>

            <!-- Modal pour ajouter une couleur-->
            <div class="modal fade" id="AjouterColor" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Ajouter une couleur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('produit.storeColor',["produit"=>$produit])}}" method="POST">

                        @csrf
                        <div class="form-group p-3">
                            <label
                                for="name"
                                >Choisir la couleur:
                            </label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                class="form-control"
                            />
                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
             </div>
            </div>

            <!-- Modal pour gerer le stock-->
            <div class="modal fade" id="gererStock" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Gestion du stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('produit.QteUpdate',["produit"=>$produit])}}" method="POST">

                        @csrf
                        <div class="form-group mt-3 p-2 ">
                            <label
                            for="stock"
                            style="color: black;"
                            >Choisir l'operation:
                            </label>
                            <select class="form-select" aria-label="Default select example" name="operation">
                                <option value="1" selected>Ajout</option>
                                <option value="0">Retrait</option>
                              </select>
                            </select>
                        </div>
                        <div class="form-group my-3 p-2">
                            <label
                                  for="qte"
                                  style="color: black;"
                                  name="qte"
                                  >Quantite :
                                </label>
                                <input
                                  id="qte"
                                  name="qte"
                                  type="text"
                                  class="form-control validate"

                                />

                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
             </div>
            </div>


            <!-- div pour l'update-->
            <div class="row">

                <div class="col-md-6 ">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Mettre a jour le produit</h5>

                      <form action="{{route('produit.update',["produit"=>$produit])}}" method="post">
                        @csrf

                          <div class="form-group mb-3">
                              <label
                              for="nomPro"
                              >Nom du produit
                              </label>
                              <input
                              id="name"
                              name="nomPro"
                              type="text"
                              class="form-control validate"
                              value="{{$produit->nomPro}}"
                              required
                              />
                          </div>
                          <div class="form-group mb-3">
                              <label
                              for="description"
                              >Description</label
                              >
                              <textarea
                              class="form-control"
                              rows="3"
                              style="height: 110px;"
                              name="description"

                              required
                              >
                              {{$produit->description}}
                          </textarea>
                          </div>
                          <div class="form-group mb-3">
                              <label
                              for="category"
                              >Categorie</label
                              >
                              <select class="form-select" aria-label="Default select example" name="categorie_id">

                              @forelse ($categories as $categorie)
                                  @if ($categorie==$produit->categorie)
                                  <option selected value="{{$categorie->id}}">{{$categorie->nomCat}}</option>
                                  @else
                                  <option value="{{$categorie->id}}">{{$categorie->nomCat}}</option>
                                  @endif
                                  @empty
                              @endforelse
                              </select>
                          </div>
                          <div class="row">
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                                  <label
                                  for="prixAchat"
                                  >Prix achat
                                  </label>
                                  @canany(['edit, create products', 'voir les finances','voir  fiche complete produit'])
                                  <input
                                  name="prixAchat"
                                  type="number"
                                  class="form-control validate"
                                  value="{{$produit->prixAchat}}"
                                  />
                                  @else
                                  <input
                                  name="prixAchat"
                                  type="text"
                                  class="form-control validate"
                                  value="****"
                                  />
                                  @endcan
                              </div>
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                                  <label
                                  for="prix"
                                  >Prix vente
                                  </label>
                                  <input

                                  name="prix"
                                  type="number"
                                  class="form-control validate"
                                  value="{{$produit->prix}}"
                                  required
                                  />
                              </div>
                          </div>
                          <div class="row">
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                              <label
                                  for="codeArrivage"
                                  >Code Arrivage
                              </label>
                              <input
                                  name="codeArrivage"
                                  type="text"
                                  class="form-control validate"
                                  value="{{$produit->codeArrivage}}"

                              />
                              </div>
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                              <label
                              for="qte"
                              >Quantite
                              </label>
                              <input
                                  value="{{$produit->qte}}"
                                  name="qte"
                                  type="number"
                                  class="form-control validate"
                                  disabled
                              />
                              </div>
                          </div>
                          <div class="row">
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                                  <label
                                  for="actif"
                                  >Actif
                                  </label>
                                  <select class="form-select" aria-label="Default select example" name='actif'>

                                  <option selected value="{{$produit->actif}}">
                                      @if($produit->actif)
                                      OUI
                                      @else
                                      Non
                                      @endif
                                  </option>
                                  <option value="1">OUI</option>
                                  <option value="0">Non</option>

                                  </select>
                              </div>
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                                  <label
                                  for="promo"

                                  >En promo
                                  </label>
                                  <select class="form-select" aria-label="Default select example" name='promo'>

                                  <option selected value="{{$produit->actif}}">
                                      @if($produit->promo)
                                      OUI
                                      @else
                                      Non
                                      @endif
                                  </option>
                                  <option value="1">OUI</option>
                                  <option value="0">Non</option>

                                  </select>
                              </div>
                              </div>

                          @can('edit, create products')
                            <div class="w-100">
                                <button type="submit" class="btn btn-primary bg-opacity-50  text-white w-100">Valider</button>
                            </div>
                          @endcan

                      </form>
                    </div>
                  </div>

                </div>

                <div class="col-md-5 offset-md-1">

                    <div class="card">
                      <div class="card-body">

                        <h5 class="card-title">Autres Caracteristiques</h5>

                        <div class="accordion" id="accordionExample">
                          @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong class="text-success">{{ $message }}</strong>
                            </div>
                          @endif
                          <div class="accordion-item">
                              <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed bg-primary bg-gradient bg-opacity-50 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Taille
                                </button>
                              </h2>
                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="max-height: 380px;">
                                <div class="accordion-body">
                                    <div class="w-100"  style="max-height: 280px; overflow:scroll ">

                                        <table class="table table-hover table-secondary table-striped">
                                          <thead>
                                            <tr>
                                              <th scope="col" class="text-center align-middle">&nbsp;</th>
                                              <th scope="col" class="text-center align-middle" >VALEUR</th>
                                              @can('edit, create products')
                                                <th scope="col" class="text-end">&nbsp;</th>
                                              @endcan
                                            </tr>
                                          </thead>
                                          <tbody >
                                            @foreach ($produit->sizes as $size)
                                              <tr>
                                                <th scope="row" class="text-center align-middle" ><input type="checkbox" /></th>
                                                <td  class="text-center align-middle">{{$size->sizeName}}</td>
                                                @can('edit, create products')
                                                  <td class="text-end">
                                                    <form action="{{route('produit.deleteSize',["size"=>$size])}}" method="POST">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button class="btn text-danger" type="submit" ><i class="bi bi-trash"></i></button>
                                                    </form>
                                                  </td>
                                                @endcan
                                              </tr>
                                            @endforeach

                                          </tbody>
                                        </table>

                                      </div>
                                    <!-- table container -->
                                    @can('edit, create products')
                                      <button class="btn btn-primary mb-3 w-100" data-bs-toggle="modal" data-bs-target="#AjouterSize">
                                          Ajouter une nouvelle taille
                                      </button>
                                    @endcan
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed bg-primary bg-gradient bg-opacity-50 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Couleur
                                </button>
                              </h2>
                              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="max-height: 380px;">
                                <div class="accordion-body">
                                    <div class="w-100"  style="max-height: 280px; overflow:scroll ">

                                        <table class="table table-hover table-secondary table-striped tm-table-small tm-product-table">
                                          <thead>
                                            <tr>
                                              <th scope="col" class="text-center align-middle">&nbsp;</th>
                                              <th scope="col" class="text-center align-middle" >Couleur</th>
                                              @can('edit, create products')
                                                <th scope="col" class="text-end">&nbsp;</th>
                                              @endcan
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($produit->colors as $color)
                                            <tr>
                                              <th scope="row" class="text-center align-middle"><input type="checkbox" /></th>
                                              <td class="text-center align-middle">  {{$color->colorName}}</td>
                                              @can('edit, create products')
                                                <td class="text-end">
                                                  <form action="{{route('produit.deleteColor',["color"=>$color])}}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button class="btn text-danger" type="submit" ><i class="bi bi-trash"></i></button>

                                                  </form>
                                                </td>
                                              @endcan

                                            </tr>
                                            @endforeach

                                          </tbody>
                                        </table>

                                      </div>

                                    <!-- table container -->
                                    @can('edit, create products')
                                      <button class="btn btn-primary  text-white mb-3 w-100" data-bs-toggle="modal" data-bs-target="#AjouterColor">
                                        Ajouter une nouvelle couleur
                                      </button>
                                    @endcan
                                </div>
                              </div>
                            </div>

                            @can('edit, create products')
                              <button type="button" class="btn btn-link mt-5 ps-0 fw-bolder text-dark" data-bs-toggle="modal" data-bs-target="#gererStock">Gerer le stock</button>
                            @endcan
                          </div>


                      </div>
                    </div>
                </div>

            </div>


            <!-- Modal pour l'historique de gestion-->
            <div class="modal fade" id="HistoStock" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title">Selectionner un interval de temps</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form>
                      <input type="hidden" name="periodCom" value="interval">
                      <div class="modal-body row">

                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                                  <label
                                  for="date1"
                                  >Debut
                                  </label>
                                  <input
                                  name="date1Ges"
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

                                  name="date2Ges"
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

          @canany(['voir les finances','voir  fiche complete produit','edit, create products'])
            <!-- Historique de gestion-->
            <div class="row  mt-3">

                <div class="col-12">
                    <div class="card overflow-auto">

                      <div class="filter w-100 text-end pe-2">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                          <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                          </li>
                          <li >
                            <form>
                              <button class="dropdown-item btn" type="submit">Ce Mois</button>
                            </form>

                          </li>
                          <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#HistoStock">Choisir un date</a></li>
                        </ul>
                      </div>

                      <div class="card-body">
                        <h5 class="card-title">Historique de gestion du stock <span>|
                          @if(isset(request()->date2Ges) || isset(request()->date1Ges))
                            Du {{request()->date1Ges}} Au {{request()->date2Ges}}
                          @else
                            Ce mois
                          @endif
                          </span>
                        </h5>

                        <table class="table datatable">
                          <thead>
                              <th scope="col" class="text-center">Date</th>
                              <th scope="col" class="text-center">Qte</th>
                              <th scope="col" class="text-center">operation</th>
                              <th scope="col" class="text-center">Agent</th>

                          </thead>
                          <tbody>
                             @foreach($gestionsHistorique as $gestion)
                              <tr>
                                <td class="text-center">{{$gestion->created_at}}</td>
                                <td class="text-center">{{$gestion->qte}}</td>
                                <td class="text-center">
                                  @if($gestion->operation)
                                    <span class="badge bg-success">Ajout</span>
                                  @else
                                    <span class="badge bg-warning">Retrait</span>
                                  @endif
                                </td>
                                <td class="text-center">{{$gestion->user->nomGest}}</td>

                              </tr>
                             @endforeach

                          </tbody>
                        </table>

                      </div>

                    </div>
                </div><!-- End Recent Sales -->
            </div>

          @endcan



        </section>

      </main><!-- End #main -->



</x-layaout>
