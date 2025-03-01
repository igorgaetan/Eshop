<x-layaout>
    <main id="main" class="main">
    <meta charset="UTF-8">
        <div class="pagetitle">
            <h1>Clients</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Client</li>
                <li class="breadcrumb-item active" >Liste</li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
      

              <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if(auth()->user()->typeGest==0)
                        <h5 class="nav justify-content-between"> <span class="card-title ">Tout les clients</span>
                        <span>
                          <form>
                            <input type="hidden" value="{{request()->search}}" name="search">
                            <input type="hidden" value="1" name="imprimer">
                            <button class="btn link-primary" type="submit">Imprimer</button>
                          </form>
                          
                          </span></h5>
                          @else
                            <h5 class="card-title ">Tout les clients</h5>
                          @endif
                  
                
                        
                         <form class="row mb-3">
                     
                            <div class="offset-md-3 col-md-6 d-flex">
                              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                              <button class="btn btn-outline-success" type="submit">Search</button>
                            </div>
                          </form>
                      
                      
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center align-middle">Matr.</th>
                                    <th scope="col" class="text-center align-middle">Nom</th>
                                 
                              
                                    <th scope="col" class="text-center align-middle">Ville</th>
                                    <th scope="col" class="text-center align-middle">Tel</th>
                                    <th scope="col" class="text-center align-middle">whatsapp</th>
                                    <th scope="col" class="text-center align-middle">Point</th>
                                    <th scope="col" class="text-center align-middle">Tontine</th>
                                    
                                  </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($clientCartes as $clientCarte)
                     
                                    <tr>
                                        <td class="text-center align-middle" ><a href="{{route('edit.clientCarte',['clientCarte'=>$clientCarte])}}">{{$clientCarte->matr}}</a></td>
                                        <td class="text-center align-middle">{{$clientCarte->nom}}</td>
                                       
                                    
                                        <td class="text-center align-middle">{{$clientCarte->ville->libelle}}</td>
                                        <td class="text-center align-middle">{{$clientCarte->mobile}}</td>
                                        <td class="text-center align-middle">
                                            @if($clientCarte->whatsapp)
                                                <span class="badge bg-success"> Oui </span>
                                            @else
                                                <span class="badge bg-warning"> Non </span>
                                            @endif
                                            
                                        </td>
                                        <td class="text-center align-middle">{{formateur($clientCarte->point)}}</td>
                                        <td class="text-center align-middle">{{formateur($clientCarte->montantTontine)}}</td>
                                         
                                    </tr>
                                    
                                @endforeach  
                               
                            </tbody>
                          </table>
                          
                          
                          <p class="text-secondary mb-0 pb-0">{{$total}} Resultats </p>
                          <p class="text-secondary mb-0 pb-0"> 
                          @if($clientCartes->hasPages())
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
                 
                         @if ($clientCartes->hasPages())
                          <ul class="pagination justify-content-center">
                              {{-- Previous Page Link --}}
                              @if ($clientCartes->onFirstPage())
                                  <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                              @else
                                  <li class="page-item"><a class="page-link" href="{{ $clientCartes->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                              @endif
                      
                              {{-- Pagination Elements --}}
                              @foreach ($clientCartes->links()->elements as $element)
                                  {{-- "Three Dots" Separator --}}
                                  @if (is_string($element))
                                      <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                  @endif
                      
                                  {{-- Array Of Links --}}
                                  @if (is_array($element))
                                      @foreach ($element as $page => $url)
                                          @if ($page == $clientCartes->currentPage())
                                              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                          @else
                                              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                          @endif
                                      @endforeach
                                  @endif
                              @endforeach
                      
                              {{-- Next Page Link --}}
                              @if ($clientCartes->hasMorePages())
                                  <li class="page-item"><a class="page-link" href="{{ $clientCartes->nextPageUrl() }}" rel="next">&raquo;</a></li>
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
      
    </main>
</x-layaout>