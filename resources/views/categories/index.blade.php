<x-layaout>
    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Categories</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
              <li class="breadcrumb-item">Categories</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->

        <section class="section">

          <!-- Modal pour la date-->
          <div class="modal fade" id="date" tabindex="-1">
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

          @can('voir les finances')
            <div class="row">
              <div class="col-12">
                <div class="card overflow-auto">
                  <div class="filter text-end pe-3">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>

                    <li>
                        <form>
                            <button class="dropdown-item"type="submit">Today</button>
                        </form>

                    </li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#date">Choisir une periode</a></li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Top Categorie
                      <span>|
                        @if(isset(request()->date1) && isset(request()->date2))
                            Du {{request()->date1}} Au {{request()->date2}}
                        @else
                            Aujourd'hui
                        @endif</span>
                    </h5>

                    <table class="table datatable">
                      <thead>
                          <tr>

                              <th scope="col" class="text-center">Categorie</th>
                              <th scope="col" class="text-center">Capital</th>
                              <th scope="col" class="text-center">Revenue</th>
                              <th scope="col" class="text-center">netPercu</th>
                              <th scope="col" class="text-center">Remise</th>

                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($topCategorieNoms as $categorie)
                              <tr>

                                <td class="text-center"><a href="{{route('categorie.edit',["categorie"=>$categorie])}}">{{$categorie}}</a></td>
                                <td class="text-center">{{number_format($capitalParCategorie[$categorie],'2','.',' ')}}</td>
                                <td class="text-center">{{number_format($recetteParCategorie[$categorie],'2','.',' ')}}</td>
                                <td class="text-center">{{number_format($netPercuParCategorie[$categorie],'2','.',' ')}}</td>
                                <td class="text-center"> @if($recetteParCategorie[$categorie]>0)
                                    {{round((1-$netPercuParCategorie[$categorie]/$recetteParCategorie[$categorie])*100,2)}}  %
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
              </div>
            </div>
          @endcan


          <div class="row">


              <!-- Categories list -->
              <div class="col-md-6 ml-0">
                  <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Vos categories</h5>

                        <form class="row mb-3">

                          <div class="col-12 d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                          </div>
                        </form>

                       <table class="table">
                          <thead>
                            <tr>
                              <th class="text-center">Preview</th>
                              <th class="text-center">
                                <b>N</b>om
                              </th>
                              <th class="text-center">
                                Produits
                              </th>
                              <th class="text-center align-middle">Statut</th>


                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($categories as $categorie)
                              <tr>
                                  <td scope="row" class="text-center">
                                    @if($categorie->image)
                                            <a href="#"><img src="{{asset($categorie->image)}}" alt="" style="border-radius: 5px;max-width: 60px;max-height: 60px;"></a>
                                    @else
                                        <a href="#"><img src="{{asset("images/1719827982284.jpg")}}" alt="" style="border-radius: 5px;max-width: 60px;max-height: 60px;"></a>
                                    @endif

                                  </td>

                                  <td class="text-center align-middle"><a href="{{route('categorie.edit',["categorie"=>$categorie])}}">{{$categorie->nomCat}}</a></td>
                                  <td class="text-center align-middle"><a href="{{route('categorie.produits',["categorie"=>$categorie])}}">Voir les produits</a></td>
                                  <td class="text-center align-middle">@if($categorie->actif) <span class="badge bg-success">Disponible</span> @else <span class="badge bg-warning"> Pas disponible </span>  @endif </td>

                              </tr>
                              @endforeach
                          </tbody>
                        </table>
                        <!-- End Table with stripped rows -->


                        <p class="text-secondary mb-0 pb-0">{{$total}} Resultats </p>
                        <p class="text-secondary mb-0 pb-0">
                        @if($categories->hasPages())
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

                         @if ($categories->hasPages())
                          <ul class="pagination justify-content-center">
                              {{-- Previous Page Link --}}
                              @if ($categories->onFirstPage())
                                  <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                              @else
                                  <li class="page-item"><a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                              @endif

                              {{-- Pagination Elements --}}
                              @foreach ($categories->links()->elements as $element)
                                  {{-- "Three Dots" Separator --}}
                                  @if (is_string($element))
                                      <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                  @endif

                                  {{-- Array Of Links --}}
                                  @if (is_array($element))
                                      @foreach ($element as $page => $url)
                                          @if ($page == $categories->currentPage())
                                              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                          @else
                                              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                          @endif
                                      @endforeach
                                  @endif
                              @endforeach

                              {{-- Next Page Link --}}
                              @if ($categories->hasMorePages())
                                  <li class="page-item"><a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">&raquo;</a></li>
                              @else
                                  <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                              @endif
                          </ul>
                        @endif

                      </div>
                    </div>

              </div><!-- End Categories list -->


              <!--  Categorie store -->
              @can('create and edit category')
              <div class=" col-md-6 ml-0">



                  <div class="card px-2">
                      @if ($message = Session::get('success'))
                          <div class="alert alert-success mt-3">
                              <strong class="text-success">{{ $message }}</strong>
                          </div>
                      @endif
                      @if ($errors->any())
                          <div class="alert alert-danger m-3">
                          @foreach ($errors->all() as $error)
                              {{$error}}
                          @endforeach
                          </div>
                      @endif



                      <div class="card-body">
                          <h5 class="card-title">Nouvelle categorie</span></h5>
                          <form action="{{ route('categorie.store') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                            <div class="form-group mb-3 ">
                              <label
                                for="nomCat"
                                >Nom de la categorie
                              </label>
                              <input
                                name="nomCat"
                                type="text"
                                class="form-control validate"
                                required
                              />
                            </div>
                            <div class="mb-3">
                              <label for="formFile"  class="form-label">Choisir un image</label>
                              <input class="form-control" name="image" type="file" id="formFile" required>
                            </div>
                            <div class="mb-3">
                                <label
                                  for="actif"
                                  >Actif
                                </label>
                                <select class="form-select" aria-label="Default select example" name='actif'>
                                  <option selected value="1">Oui</option>
                                  <option value="0">Non</option>

                                </select>
                            </div>
                            <div class="dropdown mt-3">
                              <button type="submit" class="btn btn-primary btn-block  mb-3 w-100">
                                Creer la categorie
                              </button>
                            </div>
                            </form>

                      </div>


                  </div>
              </div>
              @endcan
              <!-- End Categorie edit -->

          </div>


        </section>

      </main><!-- End #main -->



</x-layaout>
