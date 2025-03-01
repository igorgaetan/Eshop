<x-layaout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Facture Nro {{$facture->id}}</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Factures</li>
                <li class="breadcrumb-item active">Nro {{$facture->id}}
                    @if ($facture->typeFac==0)
                        <span class="badge bg-success">Cash</span>
                    @endif
                    @if ($facture->typeFac==1)
                        <span class="badge bg-success">Tontine</span>
                    @endif
                    @if ($facture->typeFac==2)
                        <span class="badge bg-success">Bon achat</span>
                    @endif
                    @if ($facture->typeFac==3)
                        <span class="badge bg-success">OM</span>
                    @endif
                    @if ($facture->typeFac==4)
                        <span class="badge bg-success">Momo</span>
                    @endif
                    @if ($facture->typeFac==5)
                        <span class="badge bg-success">Autre</span>
                    @endif

                    @if($facture->paiementValid==0)
                        <span class="badge bg-danger">Validation en attente</span>
                    @else
                        
                            <span class="badge bg-success">Payée</span>
                       
                    @endif
                </li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Vos produits
                            </h5>
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle">Preview</th>
                                        <th scope="col" class="text-center align-middle">codePro</th>
                                        
                                        <th scope="col" class="text-center align-middle">Prix</th>
                                        <th scope="col" class="text-center align-middle">Qte</th>
                                        <th scope="col" class="text-center align-middle"> SubTotal</th>
                                        @if($facture->paiementValid==0)
                                        @can('create and edit invoices')
                                            <th scope="col" class="text-center align-middle"></th>
                                        @endcan
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    @foreach ($facture->ligneFactures as $ligne)
                                    
                                    <tr>
                                        <th scope="row text-center" >
                                            @php
                                               $photo= $ligne->produit->photos->first();
                                            @endphp
                                            @if($photo)
                                                <a href="#"><img src="{{asset($photo->lienPhoto)}}" alt="" style="border-radius: 5px;max-width: 60px;"></a> 
                                            @else
                                                <a href="#"><img src="{{asset("images/1719827982284.jpg")}}" alt="" style="border-radius: 5px;max-width: 60px;"></a> 
                                            @endif
                                        </th>
                                        <td class="text-center align-middle" > <a href="{{route('produit.edit',['produit'=>$ligne->produit])}}">{{substr($ligne->produit->codePro,0,3)}}-{{substr($ligne->produit->codePro,3)}} </a> </td>
                                       
                                        <td class="text-center align-middle" id="prix">{{formateur($ligne->prix)}}</td>
                                        <td class="text-center align-middle">{{$ligne->qte}} </td>
                                        <td class="text-center align-middle" id="prixTotal">{{formateur($ligne->qte*$ligne->prix)}}</td>
                                        @if($facture->paiementValid==0)
                                            @can('create and edit invoices')
                                                <th scope="row" class="text-center align-middle">
                                                    <form method="POST" action="{{route('facture.destroyLigneFac',["ligneFacture"=>$ligne])}}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn2 btn-light border-0"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                    
                                                </th>
                                            @endcan
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($facture->paiementValid==0)
                                @can('create and edit invoices')
                                    <div class="w-100 mt-3">
                                        <a href="{{route('facture.addLigneFacView',["facture"=>$facture])}}" class="btn btn-primary w-100" style="text-decoration: none; color:rgb(255, 254, 254);">Ajouter un produit</a>
                                    </div>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>

      
                <div class="col-lg-4">
                  
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Net à payer</h5>
                            <h6 class="fw-bold fs-5">
                            {{ formateur(($facture->montant*(1-$facture->remise/100))*(1+$facture->tva/100))}} {{config('app.device')}}
                            </h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Details de la facture
                            </h5>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <strong class="text-success">{{ $message }}</strong>
                                </div>
                            @endif
                            @if ($errors->any())
                              <div class="alert alert-danger mb-3">
                               
                              @foreach ($errors->all() as $error)
                                {{$error}}
                              @endforeach
                              
                              </div>
                            @endif
                            
                    
                                
                    
                           
                            <form action="{{route('facture.update',["facture"=>$facture])}}" method="post">
                                @csrf
                                <div class="w-100 border-bottom border-1 border-dark pb-3">
                                    <div class="row">
                                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                                            <label
                                            for="montant"
                                            >Montant
                                            </label>
                                            <input
                                            name="montant"
                                            type="number"
                                            class="form-control validate"
                                            value={{$facture->montant}}
                                            disabled
                                            />
                                        </div>
                                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                                            <label
                                            for="capital"
                                            >Capital
                                            </label>
                                            @canany(['voir les finances','voir  fiche complete produit'])
                                            <input 
                                            name="capital"
                                            type="number"
                                            class="form-control validate"
                                            value={{$facture->capital}}
                                            disabled
                                            />
                                            @else
                                            <input 
                                            name="capital"
                                            type="text"
                                            class="form-control validate"
                                            value="****"
                                            disabled
                                            />
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group mb-3 col-xs-12 col-sm-6">
                                        <label
                                        for="remise"
                                        >Remise
                                        </label>
                                        <input 
                                        name="remise"
                                        type="number"
                                        class="form-control validate"
                                        value={{$facture->remise}}
                                        
                                        />
                                    </div>
                                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                                        <label
                                            for="tva"
                                            >TVA 
                                        </label>
                                        <input 
                                            name="tva"
                                            type="number"
                                            class="form-control validate"
                                            value={{$facture->tva}}
                                            
                                        />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                                            <label
                                            for="tel"
                                            >Telephone
                                            </label>
                                            <input
                                            name="tel"
                                            type="text"
                                            class="form-control validate"
                                            value={{$facture->tel}}
                                            />
                                        </div>
                                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                                            <label
                                            for="typeFac"
                                            >Type 
                                            </label>
                                            <select class="form-select" aria-label="Default select example" name="typeFac">
                                                <option selected value="{{$facture->typeFac}}">
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
                                                    
                                                    @elseif ($facture->typeFac==5)
                                                        Autre
                                                    @endif
                                                </option>
                                                <option  value="0">Cash</option>
                                                <option  value="3">OM</option>
                                                <option  value="4">Momo</option>
                                                <option  value="5">Autre</option>
                                                @if($client)
                                                    <option value="1">Tontine</option>
                                                    <option  value="2">Bon achat</option>
                                                @endif
                                                
                                            </select>
                                        </div>
                                    </div>
                                    @can('create and edit invoices')
                                        
                                        @if($facture->paiementValid==0)
                                            <button class="btn btn-primary w-100" > Terminer </button>
                                        @endif
                                       
                                    @endcan
                                </div>
                            </form>
              
                            <div class="mt-3">
                                @if ($client)
                                    
                                        <p>
                                            Nom du client: <span  class="fw-bold"><a href="{{route('edit.clientCarte',['clientCarte'=>$client->matr])}}" style="text-decoration: none; color:black;"> {{$client->nom}} </a></span>
                                        </p>
                                        <p>
                                            Matricule du client: <span class="fw-bold"> {{$client->matr}} </span>
                                        </p>
                                        <p>
                                            Montant Tontine: <span class="fw-bold"> {{formateur($client->montantTontine)}} FCFA</span>
                                        </p>
                                        <p>
                                            Point disponible: <span class="fw-bold"> {{$client->point}} </span>
                                        </p>
                                        <p>
                                            Bon d'achat disponible: <span class="fw-bold"> {{formateur($bonAchat)}} FCFA</span>
                                        </p>
                                    

                                    
                                @else
                                    <p class="fw-bold">
                                    Client non enregistré
                                    </p>
                                    <p>
                                        Contact: <span  class="fw-bold">{{$facture->tel}}</span>
                                    </p>

                                    @can('create and edit invoices')
                                        @if($facture->paiementValid==0)
                                            <form class="mt-3 py-3" action="{{route('create.ligneCarte',['facture'=>$facture])}}" method="POST">
                                                @csrf
                                                <div class="form-group mb-3">
                                                    <label>Ajouter a une carte client</label>
                                                    <input
                                                    name="tel"
                                                    type="text"
                                                    class="form-control validate"
                                                    required
                                                    /> 
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary bg-opacity-50  text-white w-100" > AJouter au client </button>
                                                
                                            <form> 
                                        @endif
                                    @endcan
                                @endif
                            
                                <a href="{{route('generateFac',['facture'=>$facture])}}"  class="btn btn-link mt-5 ps-0 fw-bolder text-dark">Voir la facture</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      
    </main>
</x-layaout>