<x-layaout>

    <main id="main" class="main">

        </div>

        <div class="pagetitle">
          <h1>Liste des produits</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
              <li class="breadcrumb-item">Produits</li>
              <li class="breadcrumb-item active">Liste</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->
    
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
    
              <div class="card">
                <div class="card-body" style="overflow-x: auto;">
                 
                  <h5 class="nav justify-content-between"> <span class="card-title ">Liste des produits</span>
                  <span>
                    <form>
                      <input type="hidden" value="{{request()->search}}" name="search">
                      <input type="hidden" value="1" name="imprimer">
                      <button class="btn link-primary" type="submit">Imprimer</button>
                    </form>
                    
                    </span></h5>
                  
                  <form class="row mb-3">
                     
                          <div class="offset-md-3 col-md-6 d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                          </div>
                  </form>
                  <!-- Table with stripped rows -->
                  <table class="table">
                    <thead>
                      <tr>
                    
                        <th class="text-center align-middle"> Preview </th>
                        <th class="text-center align-middle"> Code </th>
                        <th class="text-center align-middle"> Nom </th>
                        <th class="text-center align-middle">categorie</th>
                        <th class="text-center align-middle">Prix Vente</th>
                        @canany(['edit, create products', 'voir les finances'])
                        <th class="text-center align-middle">Prix Achat</th>
                        @endcan
                        <th class="text-center align-middle">Code Arrivage</th>
                        <th class="text-center align-middle">Qte</th>
                        <th class="text-center align-middle">Statut</th>
                        
                        
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
                            <td class="text-center align-middle">{{formateur($produit->prix)}}</td>
                            @canany(['edit, create products', 'voir les finances'])
                            <td class="text-center align-middle">{{formateur($produit->prixAchat)}}</td>
                            @endcan
                            <td class="text-center align-middle">{{$produit->codeArrivage}}</td>
                            <td class="text-center align-middle">{{$produit->qte}}</td>

                            <td class="text-center align-middle">@if($produit->actif) <span class="badge bg-success">Disponible</span> @else <span class="badge bg-warning"> Pas disponible </span>  @endif </td>                            
                            
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
          </div>
        </section>
    
    </main><!-- End #main -->

    
    
</x-layaout>