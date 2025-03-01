<x-layaout>
    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Commande Nro {{$commande->id}}</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
              <li class="breadcrumb-item">Commandes</li>
              <li class="breadcrumb-item active">Commande Nro {{$commande->id}} 
                @if($commande->type == 0 )
                    <span class="badge bg-danger"> En attente de Traitement </span>
                @elseif($commande->type == 1)
                    <span class="badge bg-primary">En cours de traitement</span>
                @elseif($commande->type == 2)
                    <span class="badge bg-success">En attente de livraison</span>
                @elseif($commande->type == 3)
                    <span class="badge bg-success">En attente de facturation</span>
                    @if($commande->livrer==1)
                        <span class="badge bg-success">livraison Faite</span>
                    @elseif($commande->livrer==2)
                        <span class="badge bg-success">Mise en reservation</span>
                    @endif
                @else
                    <span class="badge bg-success">Traitement terminer</span>
                @endif
            </li>
            </ol>
          </nav>
            @if($commande->type == 0)
                <p class="text-end fw-bold"><a href="{{route('avancerEtat',['commande'=>$commande])}}" class="text-primary">Commencer le Traitement</a> | <form action="{{route('deleteCommande',['commande'=>$commande])}}" class="text-end" method="POST"> @csrf @method('DELETE') <button class="btn btn-outline--danger" type="submit">Supprimer la commande</button></form></p>
             @elseif($commande->type == 2)
             <p class="text-end fw-bold"> <a class="text-info" href="#" id="whatsapp-button">Envoyer message</a> |  <a href="{{route('commande.generateFac',['commande'=>$commande])}}" class="text-primary">Imprimer la commande</a> | <a href="{{route('avancerEtat',['commande'=>$commande])}}" class="text-success">Valider la livraison</a> |<a href="{{route('reserver',['commande'=>$commande])}}" class="text-success">Envoyer pour reservation</a> |<a href="{{route('rentrerEtat',['commande'=>$commande])}}" class="text-secondary">Revenir en arriere</a> <p>
                
            @elseif($commande->type == 3)
            <p class="text-end fw-bold"> @can('create and edit invoices') <a href="{{route('commandeToFacture',['commande'=>$commande])}}" class="text-success">Facturer</a> @else <a href="{{route('rentrerEtat',['commande'=>$commande])}}" class="text-secondary">Revenir au traitement</a> @endcan </p>
            @endif

            @if(isset($commande->facture) && auth()->user()->typeGest==1)
                <p class="text-end fw-bold"> <a href="{{route('facture.edit',['facture'=>$commande->facture])}}" class="text-success">Voir la facture</a> </p>
            @endif


        </div><!-- End Page Title -->
    
        <section class="section"> 
            <div class="row">
                <div class="col-12">
                    
                    <div class="card">
                        <div class="card-body fw-bold">
                            <h5 class="card-title">Net à payer</h5>
                            {{ formateur(($commande->montant + $commande->montantLivraison)*(1-$commande->remise/100))}}
                            {{config('app.device')}}
                        </div>
                    </div>
        
                </div>

                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Details sur le client</h5>
                        <div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong class="text-success">{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{$error}}
                                @endforeach
                                </div>
                            @endif
                        <form action="{{route('commande.update',["commande"=>$commande])}}" method="post">
                            @csrf
                            <input type="hidden" id="commandeId" value={{$commande->id}}/>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label
                                    for="nomClient"
                                    >Nom CLient
                                    </label>
                                    <textarea
                                        class="form-control validate"
                                        rows="1"
                                        name="nomClient"
                                        >{{$commande->nomClient}}</textarea>
                                </div>
                                <div class=" col-lg-3 col-md-6 col-12">
                                    
                                    <label
                                    for="montant"
                                    >Montant
                                    </label>
                                    <input
                                    name="montant"
                                    type="number"
                                    class="form-control validate"
                                    value={{$commande->montant}}
                                    disabled
                                    />
                                    
                                    
                                </div>
                            
                                <div class="form-group mb-3 col-lg-3 col-md-6 col-12">
                                    <label
                                    for="remise"
                                    >Remise
                                    </label>
                                    <input 
                                    name="remise"
                                    type="number"
                                    class="form-control validate"
                                    value={{$commande->remise}}
                                    
                                    />
                                </div>
                                <div class="form-group mb-3 col-lg-3 col-md-6 col-12">
                                    <label
                                    for="mobile"
                                    >Telephone
                                    </label>
                                    <input
                                    name="mobile"
                                    type="text"
                                    id="tel"
                                    class="form-control validate"
                                    value={{$commande->mobile}}
                                    />
                                </div>
                                
                                <div class="form-group  col-lg-3 col-md-6 col-12">
                                    <label
                                    for="addresse"
                                    >Adresse
                                    </label>
                                    <textarea
                                        class="form-control validate"
                                        rows="1"
                                        
                                        name="addresse"
                                    >{{$commande->addresse}}</textarea>
                        
                                </div>
                                
                                
                                <div class="form-group mb-3 col-lg-3 col-md-6 col-12">
                                    <label
                                        for="ville"
                                        >Ville</label
                                    >
                                    <select class="form-select" aria-label="Default select example" name="ville_id">
                                        
                                        @foreach ($villes as $ville)
                                        @if ($ville==$commande->ville)
                                            <option selected value="{{$ville->id}}">{{$ville->libelle}}</option>
                                        @else
                                            <option value="{{$ville->id}}">{{$ville->libelle}}</option>
                                        @endif
                                        @endforeach   
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3 col-lg-3 col-md-6 col-12">
                                    
                                                                
                                        <label
                                        for="mobile"
                                        >Frais de livraison
                                        </label>
                                        
                                        <input
                                        name="montantLivraison"
                                        type="number"
                                        class="form-control validate"
                                        value="{{$commande->montantLivraison?$commande->montantLivraison:0}}"
                                        />
                                    
                                </div>
    
                                <div class="form-group mb-3  col-12 ">
                                    <label
                                    for="nomClient"
                                    >Commentaire
                                    </label>
                                    <textarea
                                        class="form-control validate"
                                        rows="3"
                                        style="height: 110px;"
                                        name="commentaire"
                                    >{{$commande->commentaire}}</textarea>
                                </div>
    
                                @if($commande->type == 1 )
                                
                                <button class="btn btn-primary w-100" > Enregistrer les modifications </button>
                            
                                @endif
                            </div>
                        </form>
                        </div>
                    
                    </div>
                    </div>
        
                </div>
            
                <div class="col-12">
                <div class="card">
                    <div class="card-body" style="overflow-x: auto;">
                    <h5 class="card-title">Produits de la commande</h5>
                
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <input class="form-control me-2" type="search" id="search" placeholder="Rechercher un produit" aria-label="Search">
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center align-middle">Preview</th>
                                    <th scope="col" class="text-center align-middle">code</th>
                                    <th scope="col" class="text-center align-middle">Nom</th>
                                    <th scope="col" class="text-center align-middle">Prix</th>
                                    <th scope="col" class="text-center align-middle">Quantite</th>
                                    <th scope="col" class="text-center align-middle">Taille</th>
                                    <th scope="col" class="text-center align-middle">Couleur</th>
                                    <th scope="col" class="text-center align-middle">Subtotal</th>
                                    @if($commande->type == 1)
                                        <th scope="col" class="text-center align-middle">Disponible</th>
                                        <th scope="col" class="text-center align-middle"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="table">
                                @foreach ($commande->ligneCommandes as $ligne)
                                
                                <tr>
                                    <th scope="row" >
                                        @php
                                        $photo= $ligne->produit->photos->first();
                                        @endphp
                                        @if($photo)
                                            <a href="#"><img src="{{asset($photo->lienPhoto)}}" alt="" style="border-radius: 5px;max-width: 60px;"></a> 
                                        @else
                                            <a href="#"><img src="{{asset("images/1719827982284.jpg")}}" alt="" style="border-radius: 5px;max-width: 60px;"></a> 
                                    
                                        @endif
                                    </th>
                                    <td class="text-center align-middle" >{{substr($ligne->produit->codePro,0,3)}}-{{substr($ligne->produit->codePro,3)}} 
                                        <input type="number" value="{{$ligne->produit->codePro}}" name="codePro" style="display:none;"/>
                                        <input type="text" value="{{$ligne->produit->nomPro}}" name="nomPro" style="display:none;"/>
                                    
                                    </td>
                                    <td class="text-center align-middle" >{{$ligne->produit->nomPro}} </td>
                                    <td class="text-center align-middle" id="prix">{{formateur($ligne->produit->prix)}}</td>
                                    <td class="text-center align-middle">{{$ligne->qte}} </td>
                                    <td class="text-center align-middle">{{$ligne->taille}} </td>
                                    <td class="text-center align-middle">{{$ligne->couleur}}</td>
                                    <td class="text-center align-middle" id="prixTotal">{{formateur($ligne->produit->prix*$ligne->qte)}}</td>
                                    @if($commande->type == 1)
                                        <td class="text-center align-middle" id="prixTotal">
                                            <input type="hidden" name="ligne_id" value="{{$ligne->id}}">
                                            @if($ligne->disponible)
                                                <input class="form-check-input check1" type="checkbox" name="disponible"  checked>      
                                            @else
                                                <input class="form-check-input  check1" type="checkbox" name="disponible" >                            
                                            @endif
                                        </td>
                                        <th scope="row" class="text-center align-middle">
                                            @if($commande->type == 1)
                                                <form action="{{route('destroyLigneCom',['ligneCommande'=>$ligne])}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn2 btn-light border-0"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @else
                                                <i class="bi bi-trash btn btn-disabled"></i>
                                            @endif
                                        </th>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($commande->type == 1 )
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <a href="{{route('addLigneComView',['commande'=>$commande])}}" class="btn btn-primary w-100" style="text-decoration: none; color:rgb(255, 254, 254);">Ajouter un produit</a>
                                </div>
                            </div>
                            
                        
                        @endif
                
                    
                    </div>
                </div>
                </div>
            </div>
        </section>
       
        @if($commande->type == 1)
                <p class="text-secondary text-end mb-0"> Assurer d'avoir enregistré les modifications avant de valider le traitement</p>
                <p class="text-end mt-0 fw-bold"><a href="{{route('avancerEtat',['commande'=>$commande])}}" class="text-success">Valider traitement</a> | <a href="{{route('rentrerEtat',['commande'=>$commande])}}" class="text-secondary">Annuler le traitement</a></p>
        @endif

      </main><!-- End #main -->


     <!-- Filtre-->
    <script>

        const elementsDUTableau = document.querySelectorAll('tr');
        
        //Pour la manipulation
        const trs=[...elementsDUTableau]
        // On supprime l'en - tete
        trs.shift();
  
        let searchBtn = document.querySelector('#search');
  
        function modifyTable(event){
          let search = event.target.value.toLowerCase();
          let tbody=document.querySelector('tbody');
          tbody.innerHTML='';
          trs.forEach(function(tr, index) {
            const codePro = tr.querySelector('input[name="codePro"]').value;
           const nomPro = tr.querySelector('input[name="nomPro"]').value.toLowerCase();
            if(codePro.includes(search) ||  nomPro.includes(search)){
              tbody.appendChild(tr)
            }
            });
  
            
        }
        searchBtn.addEventListener('input', modifyTable);
        
    </script>

    
    <!-- ajax-->
    <script>
        $(document).ready(function() {
            $('.check1').on('change', function(e) {
                let checkbox=event.target;
                //let name = $('#name').val();
                const tr = ((checkbox.parentElement).parentElement);
                const ligne = tr.querySelector('input[name="ligne_id"]').value;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "{{ route('ajax.request') }}",
                    type: "POST",
                    data: {
                        ligne:ligne,
                        disponible: checkbox.checked,
                        _token: _token
                    },
                    success: function(response) {
                        console.log(response.data);
                    },
                    error: function(error) {
                        console.log('bad');
                    }
                });
            });
        });
    </script>



    <script>
        const commandeId = parseInt(document.getElementById('commandeId').value);
        
        const siteAddress = window.location.protocol + '//' + window.location.hostname+ '/commande/genereBill/' + commandeId;
       
        document.getElementById('whatsapp-button').addEventListener('click', function() {
           
            var phoneNumber = parseInt(document.getElementById('tel').value); // Remplacez par le numéro du destinataire
            
            var message = "Bonjour, Votre commande est prête à être livrée.\n\n Rendez vous à l'adresse " + siteAddress +" pour voir les détails."; 
            var url = 'https://wa.me/' + phoneNumber + '?text=' + encodeURIComponent(message);
            window.open(url, '_blank');
        });
    </script>
    

</x-layaout>