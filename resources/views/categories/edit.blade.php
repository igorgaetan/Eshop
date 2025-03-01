<x-layaout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Categories</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Categories</li>
                <li class="breadcrumb-item active">{{$categorie->nomCat}}  @if($categorie->actif) <span class="bg-success badge"> Disponible </span> @else <span class="bg-warning badge"> Non Disponible </span> @endif</li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">

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

          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
              <div class="row">

                @isset($facture)
                    @can('voir les finances')
                        <!-- Sales Card Facture -->
                        <div class="col-xl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li>
                                <form>
                                    <button class="dropdown-item"type="submit">Aujourd'hui</button>
                                </form>

                            </li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#date">Choisir une periode</a></li>
                            </ul>
                            </div>


                            <div class="card-body">
                            <h5 class="card-title">Recette <span>| @if(request()->search=='interval')
                                Du {{request()->date1}} Au {{request()->date2}}
                                @else
                                    Aujourd'hui
                                @endif</span>
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                <h6>{{formateur($recette)}}</h6>
                                <span class="text-success small pt-1 fw-bold">{{$facture->count()}}</span> <span class="text-muted small pt-2 ps-1">Factures</span>

                                </div>
                            </div>
                            </div>

                        </div>
                        </div><!-- End Sales Card -->

                        <!-- Sales Card Facture -->
                        <div class="col-xl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                            <h5 class="card-title">Net percu <span>| @if(request()->search=='interval')
                                Du {{request()->date1}} Au {{request()->date2}}
                                @else
                                    Aujourd'hui
                                @endif</span>
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                <h6>{{formateur($netPercu)}}</h6>
                                <span class="text-success small pt-1 fw-bold"> @if($recette>0)
                                    {{round((1-$netPercu/$recette)*100,2)}}  % de remise
                                    @else
                                    0 % de remise
                                    @endif</span> <span class="text-muted small pt-2 ps-1"></span>

                                </div>
                            </div>
                            </div>

                        </div>
                        </div><!-- End Sales Card -->

                        <!-- Sales Card Facture -->
                        <div class="col-xl-4 col-md-6">
                        <div class="card info-card sales-card">


                            <div class="card-body">
                            <h5 class="card-title">Capital <span>| @if(request()->search=='interval')
                                Du {{request()->date1}} Au {{request()->date2}}
                                @else
                                    Aujourd'hui
                                @endif</span>
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                <h6>{{formateur($capital)}}</h6>
                                <span class="text-success small pt-1 fw-bold">{{$facture->count()}}</span> <span class="text-muted small pt-2 ps-1">Factures</span>

                                </div>
                            </div>
                            </div>

                        </div>
                            </div>
                        <!-- End Sales Card -->

                        <!-- Top Selling -->
                        <div class="col-12">
                        <div class="card overflow-auto">


                        <div class="card-body">
                            <h5 class="card-title">Top Selling<span>|
                                @if(request()->search=='interval')
                                    Du {{request()->date1}} Au {{request()->date2}}
                                @else
                                    Aujourd'hui
                                @endif</span>
                            </h5>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Preview</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Quantite</th>
                                        <th scope="col">Capital</th>
                                        <th scope="col">Revenue</th>
                                        <th scope="col">netPercu</th>
                                        <th scope="col">Remise</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topProduitsCodes as $code)
                                        <tr>
                                        <th scope="row">
                                            @if($photosProduits[$code])
                                                <a href="#"><img src="{{asset($photosProduits[$code]->lienPhoto)}}" style="border-radius: 5px;max-width: 60px;"></a>
                                            @else
                                            <a href="#"><img src="{{asset("images/1719827982284.jpg")}}" style="border-radius: 5px;max-width: 60px;"></a>

                                            @endif
                                        </th>
                                        <td class="text-center"><a href="{{route('produit.edit',['produit'=>$code])}}" class="text-primary fw-bold">{{substr($code,0,3)}}-{{substr($code,3)}}</a></td>

                                        <td class="text-center">{{$qteParProduit[$code]}}</td>
                                        <td class="text-center">{{$capitalParProduit[$code]}}</td>
                                        <td class="text-center">{{$recetteParProduit[$code]}}</td>
                                        <td class="text-center">{{$netPercuParProduit[$code]}}</td>
                                        <td class="text-center"> @if($recetteParProduit[$code]>0)
                                            {{round((1-$netPercuParProduit[$code]/$recetteParProduit[$code])*100,2)}}  %
                                            @else
                                            0 %
                                            @endif
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        </div>
                        </div><!-- End Top Selling -->

                    @endcan
                @endisset




                @isset($produits)
                    <div class="col-12">
                    <div class="card overflow-auto">
                        <div class="card-body">
                        <h5 class="nav justify-content-between"> <span class="card-title ">Liste des produits</span>
                            <span>
                                <form>
                                <input type="hidden" value="{{request()->search}}" name="search">
                                <input type="hidden" value="1" name="imprimer">
                                <button class="btn link-primary" type="submit">Imprimer</button>
                                </form>

                                </span>
                            </h5>

                        <form class="row mb-3">

                            <div class="offset-md-3 col-md-6 d-flex">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </div>
                        </form>


                    <table class="table">
                        <thead>
                        <tr>

                            <th class="text-center align-middle"> Preview </th>
                            <th class="text-center align-middle"> Code </th>
                            <th class="text-center align-middle"> Nom </th>
                            <th class="text-center align-middle">categorie</th>
                            <th class="text-center align-middle">Prix Vente</th>
                            <th class="text-center align-middle">Prix Achat</th>
                            <th class="text-center align-middle">Code Arrivage</th>
                            <th class="text-center align-middle">Qte</th>


                        </tr>
                        </thead>
                        <tbody>

                            @foreach ($produits as $produit)

                            <tr>

                                <th scope="row" >

                                @php
                                $photo= $produit->photos->first();
                                @endphp
                                @if($photo)
                                    <a href="#"><img src="{{asset($photo->lienPhoto)}}" alt="" style="border-radius: 5px;max-width: 60px;"></a>
                                @else
                                    <a href="#"><img src="{{asset("images/1719827982284.jpg")}}" alt="" style="border-radius: 5px;max-width: 60px;"></a>

                                @endif
                                </th>
                                <td class="text-center align-middle">
                                <a href={{route('produit.edit',['produit'=>$produit])}} class="codePro">{{substr($produit->codePro,0,3)}}-{{substr($produit->codePro,3)}} </a>
                                </td>
                                <td class="text-center align-middle">{{$produit->nomPro}}</td>
                                <td class="text-center align-middle">{{$produit->categorie->nomCat}}</td>
                                <td class="text-center align-middle">{{number_format($produit->prix)}}</td>
                                <td class="text-center align-middle">{{number_format($produit->prixAchat)}}</td>

                                <td class="text-center align-middle">{{$produit->codeArrivage}}</td>
                                <td class="text-center align-middle">{{$produit->qte}}</td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->



                    <p class="text-secondary mb-0 pb-0">{{$total}} Resultats </p>
                    <p class="text-secondary mb-0 pb-0">
                    @if($produits->hasPages())
                        @if(request()->page)
                        de {{(request()->page-1)*25+1}} à  @if(request()->page*25>$total) {{$total}} @else {{request()->page*25}} @endif
                        @else
                        de 1 à  25
                        @endif
                    @else
                        @if($total>0)
                        de 1 à  {{$total}}
                        @endif
                    @endif</p>

                    @if ($produits->hasPages())
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($produits->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $produits->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($produits->links()->elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                @endif

                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $produits->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($produits->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $produits->nextPageUrl() }}" rel="next">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    @endif


                        </div>
                    </div>

                    </div>
                @endisset

                <div class="col-12 col-md-6">
                    <div class="card">
                      <div class="card-body">
                          <h5 class="card-title">Mettre a jour la categorie</h5>
                          <form class="px-3" action="{{ route('categorie.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3 ">
                              <label
                                for="nomCat"
                                >Nom de la categorie
                              </label>
                              <input
                                id="nomCat1"
                                name="nomCat"
                                type="text"
                                class="form-control validate"
                                value={{$categorie->nomCat}}
                              />
                              <input type="hidden"  value={{$categorie->id}} name="categorie_id"/>
                            </div>
                            <div class="offcanvas-body mx-auto" style="max-height: 20em;" >
                              <img src="{{asset($categorie->image)}}" alt="Product image" id="im2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" class="img-fluid d-block w-100 h-100">
                            </div>
                            <div class="mt-3">
                              <label for="formFile" class="form-label">Changer de photo</label>
                              <input class="form-control" name="image" type="file" id="formFile">
                            </div>
                            <div class="mt-3">
                                  <label
                                    for="actif"
                                    >Actif
                                  </label>
                                  <select class="form-select" aria-label="Default select example" name='actif'>
                                    <option selected value="{{$categorie->actif}}"> @if($categorie->actif) oui @else Non @endif </option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>

                                  </select>
                            </div>
                            <div class="dropdown mt-3">
                              @can('create and edit category')
                              <button type="submit" class="btn btn-primary btn-block mb-3 w-100">
                                Valider
                              </button>
                              @endcan
                            </div>
                          </form>


                      </div>
                    </div>
                  </div>

              </div>
            </div><!-- End Left side columns -->



          </div>

        </section>

    </main>
</x-layaout>
