<x-layaout>
    <main id="main" class="main">
      <div class="pagetitle">
          <h1>
            Produits 
          </h1>
          <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
              <li class="breadcrumb-item">Produits</li>
              <li class="breadcrumb-item active">
                  Audit
              </li>
          </ol>
          </nav>
      </div>
  
        <section class="section dashboard">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Entrer le code du produit
                            </h5>
                            <form action="{{route('produits.audit')}}" method="POST">
                                  @csrf
                                  
                                  @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                    
                                    @foreach ($errors->all() as $error)
                                      {{$error}}
                                    @endforeach
                                    
                                    </div>
                                  @endif
                                  <div class="row ">
                                      <div class="col-md-6 col-12">
                                          <label
                                          >Code
                                          </label>
                                          <input name="codePro" type="search" class="form-control validate" value="{{request()->codePro}}" required>
                                      </div>
                                      <div class="col-md-6 col-12 row">
                                          <div class="form-group mb-3 col-xs-12 col-sm-6">
                                              <label
                                              for="date1"
                                              >Debut
                                              </label>
                                              <input
                                              name="date1"
                                              type="date"
                                              class="form-control validate"
                                              value="{{request()->date1}}"
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
                                              value="{{request()->date2}}"
                                              
                                              />
                                          </div>
                                      </div>
                                  </div>
  
                                    <button type="submit" class="btn btn-primary w-100" id="addProduit"> Rechercher </button>
                                    
                              </form>
  
                        </div>
                    </div>
                </div>
                
            </div>
            
            
            @if(isset($produit))
              <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Produits</a></li>
                    <li class="breadcrumb-item">Audit</li>
                    <li class="breadcrumb-item active fw-bold">
                         <a href={{route('produit.edit',['produit'=>$produit])}}>{{substr($produit->codePro,0,3)}}-{{substr($produit->codePro,3)}} </a>
                    </li>
                </ol>
              </nav>
                
                <div class='row'> 
                  
                  <div class="col-xxl-4 col-md-6">

                      <div class="card info-card">

                    
                        <div class="card-body">
                            <h5 class="card-title">Quantite sur factures </h5>
                        

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$sumFacture}}</h6>
                                </div>
                            </div>

                        </div>
                      </div>

                  </div>
                  
                  <div class="col-xxl-4 col-md-6">

                      <div class="card info-card">

                    
                        <div class="card-body">
                            <h5 class="card-title">Quantite ajoutée </h5>
                        

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-plus-circle"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$sumAjout}}</h6>
                                </div>
                            </div>

                        </div>
                      </div>

                  </div>
                  
                  <div class="col-xxl-4 col-md-6">

                      <div class="card info-card">

                    
                        <div class="card-body">
                            <h5 class="card-title">Quantite retirée </h5>
                        

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-dash-circle"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$sumRetrait}}</h6>
                                </div>
                            </div>

                        </div>
                      </div>

                  </div>
                  
                  <div class="col-xxl-4 col-md-6">

                      <div class="card info-card">

                    
                        <div class="card-body">
                            <h5 class="card-title">Quantite restante </h5>
                        

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$produit->qte}}</h6>
                                </div>
                            </div>

                        </div>
                      </div>

                  </div>
                </div>
                
                <div class='row'>
                
                  <div class='col-12'>
                      
                    <div class="card recent-sales overflow-auto">
      
                      <div class="card-body">
                        <h5 class="card-title"> Factures <span>| </span></h5>
      
                        <table class="table datatable">
                          <thead>
                            <tr>
                              <th scope="col" class="text-center">#Facture</th>
                              <th scope="col" class="text-center">Date</th>
                              <th scope="col" class="text-center">Quantity</th>
                              <th scope="col" class="text-center">Prix vente</th>
                              <th scope="col" class="text-center">Prix Achat</th>
                              <th scope="col" class="text-center">Paiement</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($lignesFac as $ligne)
                                  <tr>
                                      <th scope="row" class="text-center"><a href="{{route('facture.edit',['facture'=>$ligne->facture])}}">#{{$ligne->facture->id}}</a></th>
                                      <td class="text-center">{{$ligne->created_at->format('d-m-Y')}}</td>
                                      <td class="text-center">{{$ligne->qte}}</td>
                                      <td class="text-center">{{$ligne->prix}}</td>
                                      <td class="text-center">{{$ligne->prixAchat}}</td>
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
                    </div>
                  </div>
                  
                  <div class='col-12'>
                      
                    <div class="card recent-sales overflow-auto">
      
                      <div class="card-body">
                        <h5 class="card-title"> Gestion du stock </h5>
                        
                        <form class="row mb-3">
                     
                          <div class="offset-md-3 col-md-6 d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search">
                            
                          </div>
                        </form>
      
                        <table class="table datatable table1">
                          <thead>
                            <tr>
                              <th scope="col" class="text-center">Date</th>
                              <th scope="col" class="text-center">Qte</th>
                              <th scope="col" class="text-center">operation</th>
                              <th scope="col" class="text-center">Agent</th>
                             </tr>
                          </thead>
                          <tbody>
                             @foreach($lignesStock as $gestion)
                              <tr>
                                <td class="text-center">{{$gestion->created_at->format('d-m-Y')}}</td>
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
                    </div>
                  </div>
                  
                  
                  
                 
                </div>
              
            @endif
        </section>
      
    </main>
  
    <script>
     //Filtre

            const elementsDUTableau = document.querySelectorAll('.table1 tr');
      
            //Pour la manipulation
            const trs=[...elementsDUTableau]
            // On supprime l'en - tete
            trs.shift();

            let searchBtn = document.querySelector('#search');

            function modifyTable(event){
              let search = event.target.value;
              let tbody=document.querySelector('.table1 tbody');
              tbody.innerHTML='';
              trs.forEach(function(tr, index) {
                const tds = tr.querySelectorAll('td');
                
                tds.forEach(function(td, index) {
                   if((td.innerText.toLowerCase()).includes(search.toLowerCase())){
                      tbody.appendChild(tr)
                  }
                
                });
              
                });  
            }
            searchBtn.addEventListener('input', modifyTable);
      
    </script>
    
    
    
    
  </x-layaout>