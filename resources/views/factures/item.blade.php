<x-layaout>
    <main id="main" class="main">


       <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Validation de la facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="{{route('facture.store')}}" method="POST">
                  @csrf

                  <div class="row">
                    <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="montant"
                          >MONTANT
                        </label>
                        <input
                          name="montant"
                          type="number"
                          class="form-control validate"
                        />
                      </div>
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="capital"
                          >CAPITAL
                        </label>
                        <input 
                          name="capital"
                          type="number"
                          class="form-control validate"
                          value="0"
                        />
                      </div>
                </div>
                <div class="row">
                  <div class="form-group mb-3 col-xs-12 col-sm-6">
                    <label
                      for="remise"
                      >REMISE
                    </label>
                    <input 
                      name="remise"
                      type="number"
                      class="form-control validate"
                      value="0"
                      required
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
                        value="0"
                        required
                      />
                    </div>
              </div>
              <div class="row">
                <div class="form-group mb-3 col-xs-12 col-sm-6">
                    <label
                      for="tel"
                      >TELEPHONE
                    </label>
                    <input
                      name="tel"
                      type="text"
                      class="form-control validate"
                    />
                  </div>
                  <div class="form-group mb-3 col-xs-12 col-sm-6">
                    <label
                      for="typeFac"
                      >TYPE 
                    </label>
                    <select class="form-select" aria-label="Default select example" name="typeFac">
                    
                        <option selected value="0">Non payé</option>
                        <option value="1">En cours</option>
                        <option  value="2">Payé</option>
                        
                    </select>
                  </div>
                  <input name="ligneFacture" id="ligneFacture" type="hidden"/>
            </div>
                  

                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Valider</button>
              </form>
              </div>
            </div>
          </div>
        </div>

        <div class="pagetitle">
            <h1>Factures</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Factures</li>
                <li class="breadcrumb-item">Nouveau</li>
                <li class="breadcrumb-item">Panier</li>
            </ol>
            </nav>
        </div>


        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Validation de la facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="{{route('facture.store')}}" method="POST">
                  @csrf
        
                  <div class="row">
                    <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="montant"
                          >MONTANT
                        </label>
                        <input
                          name="montant"
                          type="number"
                          class="form-control validate"
                        />
                      </div>
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="capital"
                          >CAPITAL
                        </label>
                        <input 
                          name="capital"
                          type="number"
                          class="form-control validate"
                          value="0"
                        />
                      </div>
                </div>
                <div class="row">
                  <div class="form-group mb-3 col-xs-12 col-sm-6">
                    <label
                      for="remise"
                      >REMISE
                    </label>
                    <input 
                      name="remise"
                      type="number"
                      class="form-control validate"
                      value="0"
                      required
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
                        value="0"
                        required
                      />
                    </div>
              </div>
              <div class="row">
                <div class="form-group mb-3 col-xs-12 col-sm-6">
                    <label
                      for="tel"
                      >TELEPHONE
                    </label>
                    <input
                      name="tel"
                      type="text"
                      class="form-control validate"
                    />
                  </div>
                  <div class="form-group mb-3 col-xs-12 col-sm-6">
                    <label
                      for="typeFac"
                      >TYPE 
                    </label>
                    <select class="form-select" aria-label="Default select example" name="typeFac">
                     
                        <option selected value="0">Non payé</option>
                        <option value="1">En cours</option>
                        <option  value="2">Payé</option>
                         
                    </select>
                  </div>
                  <input name="ligneFacture" id="ligneFacture" type="hidden"/>
            </div>
                  
        
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Valider</button>
              </form>
              </div>
            </div>
          </div>
        </div>
        <section class="section dashboard row">
       
              <div class="card col-12" >
                <div class="card-title">
                  <h5> Produits </h5>
                </div>
                <div class="card-body" style="max-height:700px; overflow:scroll ">
                  
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col" class="text-center align-middle">Code</th>
                            <th scope="col" class="text-center align-middle">Nom</th>
                            <th scope="col" class="text-center align-middle">Prix</th>
                            <th scope="col" class="text-center align-middle">Quantite disponible</th>
                            <th scope="col" class="text-center align-middle">Quantite desiree</th>
                            <th scope="col" class="text-center align-middle">Prix total</th>
                            <th scope="col" class="text-center align-middle">
    
                              <button type="button" id="viderPanier" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="vider le panier">
                                <i class="bi bi-cart"></i>
                              </button>
                            </th>
                        </thead>
                        
                        <tbody id="table">
                          <script>
                            let stringArray = localStorage.getItem("cart");
                            myArray = JSON.parse(stringArray); 
                            myArray.forEach(function(line, index) {
                                const tr=`<tr>
                                  <input name="image" value="${line["image"]}" type="hidden">
                                <td class="text-center align-middle codePro" style="cursor:pointer;" >${line["codePro"].substring(0,3)}-${line["codePro"].substring(3)}</td>
                                <td class="text-center align-middle" >${line["nomPro"]}</td>
                                <td class="text-center align-middle" id="prix">${line["prix"]}</td>
                                <td class="text-center align-middle">${line["qteDispo"]}</td>
                                <td class="text-center align-middle">
                                    <input class="form-label border-0 bg-light qte text-center" value="${line["qte"]}" name="qte" type="number"/>
                                    <input type="number" value="${line["codePro"]}" name="codePro" style="display:none;"/>
                                    <input type="number" value="${line["prix"]}" name="prix" style="display:none;"/>
                                    <input type="number" value="${line["qteDispo"]}" name="qteDispo" style="display:none;"/>
                                    <input type="text" value="${line["nomPro"]}" name="nomPro" style="display:none;"/>
                                    <input type="text" value="${line["prixAchat"]}" name="prixAchat" style="display:none;"/>
                                    <button class="btn btn1 btn-light border-0" type="submit" style="display: none;" ></button>
                            
                                </td>
                                <td class="text-center align-middle" id="prixTotal">${line["prix"]*line["qte"]}</td>
                                <th scope="row" class="text-center align-middle"><button class="btn btn2 btn-light border-0" type="submit" ><i class="bi bi-trash"></i></button></th>
                                </tr>` 
                            const table = document.getElementById("table");
                            table.innerHTML+=tr;
                                }); 
                          </script>
                           
                        </tbody>
                      </table>

                      <a
                      class="btn bg-primary bg-opacity-50  text-white mt-3 w-100" id="valider">Valider et avancer</a>
                      <a
                      class="btn btn-ligh mt-3 w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="valider_button" style="display: none">Valider et avancer</a>
                    
                 
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

    <!-- style pour le toast-->
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

    <!-- Script pour le toast-->
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



  //Supprimer du panier au panier
  function handlePanierDel(event){
      const btn = event.target;
      const tr = ((btn.parentElement).parentElement).parentElement;
      const codePro = tr.querySelector('input[name="codePro"]').value;
      if (localStorage.getItem("cart")) {
          let stringArray = localStorage.getItem("cart");
          myArray = JSON.parse(stringArray);   
          
          // Remove the object with the matching codePro
          for (let i = 0; i < myArray.length; i++) {
              const obj = myArray[i];
              if (obj["codePro"] === codePro) {
                  myArray.splice(i, 1); // Remove the object at index i
                  localStorage.setItem("cart", JSON.stringify(myArray));
                  window.location.reload();
              }
          } 
         
  }}
  const submitButtons = document.querySelectorAll('.btn2');
  submitButtons.forEach(function(submitButton, index) {
  submitButton.addEventListener('click', handlePanierDel); // Attach the click event listener
    });



  //vider le panier
  function handlePanierVide(event) {
      myArray = [];
      localStorage.setItem("cart", JSON.stringify(myArray));
      window.location.reload();
  }
  const viderButton = document.querySelector('#viderPanier');
  viderButton .addEventListener('click', handlePanierVide); 



       //Ajout au panier
       function handlePanierAdd(event){
        const btn = event.target;
        const tr = (btn.parentElement).parentElement;
        const codePro = tr.querySelector('input[name="codePro"]').value;
        const prix = tr.querySelector('input[name="prix"]').value;
        const qte = tr.querySelector('input[name="qte"]').value;
        const nomPro = tr.querySelector('input[name="nomPro"]').value;
        const qteDispo = tr.querySelector('input[name="qteDispo"]').value;
        const prixAchat = tr.querySelector('input[name="prixAchat"]').value;

        
        if(qte>0){
            const myJsonObject = {
            "codePro": codePro, 
            "qte": qte,  
            "prix": prix,
            "nomPro": nomPro,
            "qteDispo":qteDispo,
            "prixAchat":prixAchat
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
           
        }
        
    }
    const submitButtons1 = document.querySelectorAll('.btn1');
    submitButtons1.forEach(function(submitButton, index) {
    submitButton.addEventListener('click', handlePanierAdd); // Attach the click event listener
      });
    //Validation
    function handlePanierValidate(event) {
      //Mise a jour du panier
      submitButtons1.forEach(function(submitButton, index) {
      submitButton.click(); 
        });

      //Mis a jour du formulaire
      const form = document.querySelector("#staticBackdrop");
      const montant = form.querySelector('input[name="montant"]');
      const capital = form.querySelector('input[name="capital"]');
      montant.value=0;
      capital.value=0;

      if (localStorage.getItem("cart")) {
          let stringArray = localStorage.getItem("cart");
          let myArray = JSON.parse(stringArray);   
          
          for (let i = 0; i < myArray.length; i++) {
              const obj = myArray[i];
              montant.value=parseInt(montant.value)+obj["qte"]*obj["prix"];
              capital.value=parseInt(capital.value)+obj["qte"]*obj["prixAchat"];
              
          } 

          const ligneFacture=document.getElementById('ligneFacture');
         ligneFacture.value=JSON.stringify(myArray);
         
  }
    const valider_button = document.querySelector('#valider_button');
    valider_button.click(); 
  }
  button_valider=document.getElementById('valider');
  button_valider.addEventListener('click', handlePanierValidate);

</script>

</x-layaout>