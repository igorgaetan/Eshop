<x-layaout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>@if ($directly)
              Facture N0 {{$facture->id}}       
            @else
              Facture    
            @endif</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Factures</li>
                <li class="breadcrumb-item active">
                  @if ($directly)
                  AJouter des produits       
                  @else
                    Nouveau    
                  @endif
                </li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
      
              <div class="card">
                <div class="card-title">
                  <h5>Selectionner des produits pour la facture</h5>
                </div>
                <div class="card-body row">
                  <div class="col-md-6 offset-md-6 mb-2 ">
                    <form action="" class="w-100 bd-highlight d-flex">
                      <input class="form-control me-2" value="{{request()->search}}" type="search" name="search" placeholder="Rechercher un produit" aria-label="Search">
                      <button class="btn btn-light" type="submit">Search</button>
                    </form>
                  </div>
                  <div class="col-lg-12">
                    
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col" class="text-center align-middle">Code</th>
                            <th scope="col" class="text-center align-middle">Nom</th>
                            <th scope="col" class="text-center align-middle">Categorie</th>
                            <th scope="col" class="text-center align-middle">Prix</th>
                            <th scope="col" class="text-center align-middle">Qte dispo.</th>
                            <th scope="col" class="text-center align-middle">Qte</th>
                            <th scope="col" class="text-center align-middle">Prix total</th>
                            <th scope="col" class="text-center align-middle">
                              @if (!$directly)
                                <button type="button" id="viderPanier" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="vider le panier">
                                  <i class="bi bi-cart"></i>
                                </button>
                              @endif
                            </th>
                        </thead>
                        
                        <tbody>
                          @foreach ($produits as $produit)
               
                          <tr>
                           
                           @if($produit->photos->first())
                            <input name="image" value="{{asset($produit->photos->first()->lienPhoto)}}" type="hidden">
                            @else
                                      
                            <input name="image" value="{{asset("images/1719827982284.jpg")}}" type="hidden">
                            @endif


                            @if ($directly)
                              <form action="{{route('facture.storeLigneFac',["facture"=>$facture])}}" method="post">
                                @csrf
                            @endif
                              <td class="text-center align-middle codePro" style="cursor: pointer;" >{{substr($produit->codePro,0,3)}}-{{substr($produit->codePro,3)}}</td>
                              <td class="text-center align-middle" >{{$produit->nomPro}}</td>
                              <td class="text-center align-middle">
                                
                                  {{$produit->categorie->nomCat}}
                            
                              </td>
                      
                              <td class="text-center align-middle" id="prix">{{$produit->prix}}</td>
                              <td class="text-center align-middle">{{$produit->qte}}</td>
                              <td class="text-center align-middle">
                                  <input class="border-0 bg-light qte text-center" name="qte" type="number"/>
                                  <input type="number" value="{{$produit->codePro}}" name="codePro" style="display:none;"/>
                                  <input type="number" value="{{$produit->prix}}" name="prix" style="display:none;"/>
                                  <input type="text" value="{{$produit->nomPro}}" name="nomPro" style="display:none;"/>
                                  <input type="number" value="{{$produit->qte}}" name="qteDispo" style="display:none;"/>
                                  <input type="number" value="{{$produit->prixAchat}}" name="prixAchat" style="display:none;"/>
                              
                              </td>
                              <td class="text-center align-middle" id="prixTotal">0</td>
                              <th scope="row" class="text-center align-middle">
                                
      
                                @if ($directly)
                                  <button class="btn btn-light border-0" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter a la facture" ><i class="bi bi-cart3"></i></button>
                                  </form>
                                @else
                                  <i class="bi bi-cart3 btn btn1"></i>
                            
                                @endif
                                </th>
                            
                          </tr>
                          @endforeach 
                           
                        </tbody>
                      </table>
                      {{$produits->links()}}
                      <style>
                        .hidden:last-child{
                          display: none;
                        }
                      </style>
                  </div>
          
                </div>
              </div>
             
          
      
            </div>
          </section>
      
    </main>


    <!-- Div pour l'image au hover-->
    <div style="
      position:fixed;
      right:0%;
      top:10%;
      max-width:200px;
      max-height:200px;
      z-index:1;
      ">
      
      <img src="#" id="imageHover" class="w-100 h-100"/>

      <script>
        const codePros=document.querySelectorAll('.codePro');
        console.log(codePros);

        function displayPhoto(event){
    
          const td = event.target;
          const tr = td.parentElement;

          const src=tr.querySelector('input[name="image"]').value;
          const divIm=document.querySelector('#imageHover');
          divIm.src=src;
        }
        function RemovePhoto(event){
          const divIm=document.querySelector('#imageHover');
          divIm.src="";
        }
      
        
        codePros.forEach(function(codePro, index) { 
          codePro.addEventListener('mouseover', displayPhoto); // Attach the click event listener
            });
        codePros.forEach(function(codePro, index) {
        codePro.addEventListener('mouseout', RemovePhoto); // Attach the click event listener
          });
      </script>
    </div>

    <style>
    
        .toast { 
      position: fixed; 
      top: 90px; 
      right: 25px; 
      max-width: 300px; 
      background: #fff; 
      padding: 0.5rem; 
      border-radius: 4px; 
      box-shadow: -1px 1px 10px
        rgba(0, 0, 0, 0.3); 
      z-index: 1023; 
      animation: slideInRight 0.3s 
          ease-in-out forwards, 
        fadeOut 0.5s ease-in-out 
          forwards 3s; 
      transform: translateX(110%); 
      } 

      .toast.closing { 
        animation: slideOutRight 0.5s 
          ease-in-out forwards; 
      } 

      .toast-progress { 
        position: absolute; 
        display: block; 
        bottom: 0; 
        left: 0; 
        height: 4px; 
        width: 100%; 
        background: #b7b7b7; 
        animation: toastProgress 3s 
          ease-in-out forwards; 
      } 

      .toast-content-wrapper { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
      } 

      .toast-icon { 
        padding: 0.35rem 0.5rem; 
        font-size: 1.5rem; 
      } 

      .toast-message { 
        flex: 1; 
        font-size: 0.9rem; 
        color: #000000; 
        padding: 0.5rem; 
      } 

      .toast.toast-success { 
        background: #95eab8; 
      } 

      .toast.toast-success .toast-progress { 
        background-color: #2ecc71; 
      } 

      .toast.toast-danger { 
        background: #efaca5; 
      } 

        .toast.toast-danger .toast-progress { 
          background-color: #e74c3c; 
        } 

        .toast.toast-info { 
          background: #bddaed; 
        } 

        .toast.toast-info .toast-progress { 
          background-color: #3498db; 
        } 

        .toast.toast-warning { 
          background: #ead994; 
        } 

        .toast.toast-warning .toast-progress { 
          background-color: #f1c40f; 
        } 

        @keyframes slideInRight { 
          0% { 
            transform: translateX(110%); 
          } 

          75% { 
            transform: translateX(-10%); 
          } 

          100% { 
            transform: translateX(0%); 
          } 
        } 

        @keyframes slideOutRight { 
          0% { 
          transform: translateX(0%); 
        } 

        25% { 
          transform: translateX(-10%); 
        } 

        100% { 
          transform: translateX(110%); 
        } 
      } 

      @keyframes fadeOut { 
        0% { 
          opacity: 1; 
        } 

        100% { 
          opacity: 0; 
        } 
      } 

      @keyframes toastProgress { 
        0% { 
          width: 100%; 
        } 

        100% { 
          width: 0%; 
        } 
      }
      .toast:not(.show) {
        display: block; 
      }
    </style>

    <script> 

        let icon = { 
          success: 
          '<span class="material-symbols-outlined">Alerte</span>', 
          danger: 
          '<span class="material-symbols-outlined">error</span>', 
          warning: 
          '<span class="material-symbols-outlined">warning</span>', 
          info: 
          '<span class="material-symbols-outlined">info</span>', 
        }; 
        
        const showToast = ( 
          message = "Sample Message", 
          toastType = "info", 
          duration = 5000) => { 
          if ( 
            !Object.keys(icon).includes(toastType)) 
            toastType = "info"; 
        
          let box = document.createElement("div"); 
          box.classList.add( 
            "toast", `toast-${toastType}`); 
          box.innerHTML = ` <div class="toast-content-wrapper"> 
                  <div class="toast-icon"> 
                  ${icon[toastType]} 
                  </div> 
                  <div class="toast-message">${message}</div> 
                  <div class="toast-progress"></div> 
                  </div>`; 
          duration = duration || 5000; 
          box.querySelector(".toast-progress").style.animationDuration = 
              `${duration / 1000}s`; 
        
          let toastAlready = 
            document.body.querySelector(".toast"); 
          if (toastAlready) { 
            toastAlready.remove(); 
          } 
        
          body= document.querySelector("main");
          body.appendChild(box)
        }; 
        
    </script>

    <script>
       
        //Afficher le prix total
        function handleInputChange(event) {
          const ChangedInput = event.target;
          const value=ChangedInput.value;
          const tr = (ChangedInput.parentElement).parentElement;
          const prix = parseInt(tr.querySelector('#prix').innerHTML);
          const prixTotal = tr.querySelector('#prixTotal');
          if(value>0){
              prixTotal.innerHTML=value*prix;
          }else{
            ChangedInput.value=1;
          }
        }
        const inputs=document.querySelectorAll('.qte');

        inputs.forEach(function(input, index) {
        input.addEventListener('change', handleInputChange); 
          });

        //Ajouter au panier
        function handlePanierAdd(event){
            const btn = event.target;
            const tr = ((btn.parentElement).parentElement);
            const codePro = tr.querySelector('input[name="codePro"]').value;
            const prix = tr.querySelector('input[name="prix"]').value;
            const qte = tr.querySelector('input[name="qte"]').value;
            const nomPro = tr.querySelector('input[name="nomPro"]').value;
            const qteDispo = tr.querySelector('input[name="qteDispo"]').value;
            const prixAchat = tr.querySelector('input[name="prixAchat"]').value;
            const image = tr.querySelector('input[name="image"]').value;


            
            if(qte>0){
                const myJsonObject = {
                "codePro": codePro, 
                "qte": qte,  
                "prix": prix,
                "nomPro": nomPro,
                "qteDispo":qteDispo,
                "prixAchat":prixAchat,
                "image":image
                };

                let myArray = [];
                if (localStorage.getItem("cart")) {
                    let stringArray = localStorage.getItem("cart");
                    myArray = JSON.parse(stringArray);   
                    
                    // Remove the object with the matching codePro
                    for (let i = 0; i < myArray.length; i++) {
                        const obj = myArray[i];
                        if (obj["codePro"] === myJsonObject["codePro"]) {
                            myArray.splice(i, 1); // Remove the object at index i
                            
                        }
                    }
                
                } else {
                    // Create a new empty array
                    myArray = [];
                }
                myArray.push(myJsonObject);
                localStorage.setItem("cart", JSON.stringify(myArray));
                console.log(myArray);
                showToast("Produit ajouté","success",3500); 
              }
            
        }
        const submitButtons = document.querySelectorAll('.btn1');
        submitButtons.forEach(function(submitButton, index) {
          
        submitButton.addEventListener('click', handlePanierAdd); // Attach the click event listener
          });

        //vider le panier
        function handlePanierVide(event) {
            myArray = [];
            localStorage.setItem("cart", JSON.stringify(myArray));

            showToast("Panier vidé","success",3500); 
        }
         const submitButton = document.querySelector('#viderPanier');
        submitButton.addEventListener('click', handlePanierVide); 


      
    </script>

</x-layaout>