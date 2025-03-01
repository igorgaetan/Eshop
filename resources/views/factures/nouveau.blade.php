<x-layaout>
    <main id="main" class="main">

        <!-- Validation de la facture -->
      <div class="modal fade" id="validationFacture" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Information sur le client</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('facture.store')}}" id="formSubmit" method="POST">
            <div class="modal-body">

                @csrf

                  <div class="form-group mb-3">
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

                   <input class="form-select" type='hidden' value='0'name="typeFac">
                    <input name="ligneFacture" type="hidden"/>
                    <input name="remise"  type="hidden"/>
                    <input name="tva" type="hidden"/>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Valider</button>

            </div>
          </form>
          </div>
        </div>
      </div>


      <div class="pagetitle">
          <h1>
            Facture
          </h1>
          <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>

              <li class="breadcrumb-item active">
                  Factures
              </li>
              <li class="breadcrumb-item active">
                  Nouvelle
              </li>
          </ol>
          </nav>
      </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Rechercher un produit
                            </h5>
                            <div class="row mb-3">
                                <div class="col-md-6 col-12">
                                    <label
                                    for="codePro"
                                    >Code
                                    </label>
                                    <input name="codePro" id="codeSearch" type="text" class="form-control validate">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label
                                    for="prix"
                                    >Prix
                                    </label>
                                    <input type="number" id="prixSearch"  class="form-control validate" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 col-12">
                                    <label
                                    for="qte"
                                    >Qte
                                    </label>
                                    <input type="number"  id="qte1Search" value="1" class="form-control validate">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label
                                    for="nomClient"
                                    >qteDispo
                                    </label>
                                    <input type="number" id="qteSearch"  disabled class="form-control validate">
                                </div>
                                <div class="col-12 mt-3">
                                    <label
                                    for="nomClient"
                                    >Total
                                    </label>
                                    <input type="number" id="totalSearch" class="form-control validate" disabled>
                                </div>
                            </div>
                            <div class="w-100 text-center mb-3" id="spinner" style="display: none;">
                                <button class="btn btn-primary w-100" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>

                            <button class="btn btn-primary w-100" id="addProduit" disabled> Ajouter </button>


                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Preview</div>
                            <div class="row flex-row flex-nowrap" style="height:250px;overflow-x: auto;" id="photos">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" >
                            <h5 class="card-title">Vos produits</h5>
                            <div class="row">
                                <div class="col-md-6 offset-md-6">
                                    <input class="form-control me-2" type="search" id="search" placeholder="Rechercher un produit" aria-label="Search">
                                </div>
                            </div>
                            <div style="max-height: 500px; overflow:scroll">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center align-middle">Preview</th>
                                            <th scope="col" class="text-center align-middle">code</th>

                                            <th scope="col" class="text-center align-middle">Qte Dispo.</th>
                                            <th scope="col" class="text-center align-middle">Prix</th>
                                            <th scope="col" class="text-center align-middle">Quantite</th>
                                            <th scope="col" class="text-center align-middle"> Subtotal</th>
                                            <th scope="col" class="text-center align-middle">

                                                <i class="bi bi-trash3-fill btn text-danger fw-bold" id="viderPanier" data-bs-toggle="tooltip" data-bs-placement="top" title="Tous effacer"></i>

                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody id="table">




                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Montant</h5>
                            <div class="row mb-3">
                                <div class="col-md-6 col-lg-3 col-12">
                                    <label
                                    for="Total"
                                    >Total
                                    </label>
                                    <input type="number" id="montantTotal" class="form-control validate" disabled>
                                </div>
                                <div class="col-md-6 col-lg-3 col-12">
                                    <label
                                    for="nomClient"
                                    >Remise
                                    </label>
                                    <input type="number" class="form-control validate" name="remise" id="remise" value="0">
                                </div>
                                <div class="col-md-6 col-lg-3 col-12">
                                    <label
                                    for="nomClient"
                                    >Tva
                                    </label>
                                    <input type="number" class="form-control validate" name="tva" id="tva" value="0">
                                </div>

                                <div class="col-md-6 col-lg-3 col-12">
                                    <label
                                    for="nomClient"
                                    >Net a payer
                                    </label>
                                    <input type="number" class="form-control validate" id="netPaye" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 offset-md-6">
                                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#validationFacture" > Valider la facture </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

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

     <!-- ajax-->
     <script>
        $(document).ready(function() {
            $('#codeSearch').on('input', function(e) {

                let code=event.target.value;

                if(code.length==7){

                    //On supprime le tiret
                    const codePro=code.slice(0,3)+code.slice(4);

                    //On active le spinner
                    let spinner = document.querySelector('#spinner');
                    spinner.style.display='block';

                    //Le  token
                    let _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "{{ route('findProduit') }}",
                        type: "POST",
                        data: {
                            codePro:codePro,
                            _token: _token
                        },
                        success: function(response) {
                            spinner.style.display='none';
                            if(response.success){
                                showToast("Produit trouvé","success",3500);
                                let prix = document.querySelector('#prixSearch');
                                let qte = document.querySelector('#qteSearch');
                                let total = document.querySelector('#totalSearch');
                                let btn = document.querySelector('#addProduit');
                                const qte1Search= document.querySelector('#qte1Search');
                                qte1Search.value=1;
                                prix.value=parseFloat(response.prix),
                                qte.value=parseInt(response.qte),
                                total.value=parseFloat(response.prix),

                                qte.value>0?btn.disabled=false:btn.disabled=true

                                //Gestion des photos
                                let photos=response.photos;
                                let div = document.querySelector('#photos');
                                div.innerHTML="";
                                photos.forEach(function(photo, index) {
                                    const baseUrl = window.location.origin;


                                    const imageElement = document.createElement("img");
                                    imageElement.src = `${baseUrl}/${photo["lienPhoto"]}`;
                                    imageElement.className = "h-100 w-50 image";

                                    // Par exemple, ajouter l'image à un élément de la page
                                    div.appendChild(imageElement);
                                });

                            }else{
                                showToast("Aucun produit trouvé","warning",3500);
                                let prix = document.querySelector('#prixSearch');
                                let qte = document.querySelector('#qteSearch');
                                let total = document.querySelector('#totalSearch');
                                let btn = document.querySelector('#addProduit');
                                prix.value=0;
                                qte.value=0;
                                total.value=0;
                                btn.disabled=true;

                                let div = document.querySelector('#photos');
                                div.innerHTML="";
                            }

                        },
                        error: function(error) {
                            spinner.style.display='none';
                            console.log('Erreur de traitement');
                            showToast("Aucun produit trouvé","error",3500);
                        }
                    });
                }else{
                    let prix = document.querySelector('#prixSearch');
                    let qte = document.querySelector('#qteSearch');
                    let total = document.querySelector('#totalSearch');
                    let btn = document.querySelector('#addProduit');
                    prix.value=0;
                    qte.value=0;
                    total.value=0;
                    btn.disabled=true;

                    let div = document.querySelector('#photos');
                    div.innerHTML="";
                }
            });
        });
    </script>

    <!-- Gestion du panier de produit-->
    <script>
        //Mise a jour du total search
        const qte1Search= document.querySelector('#qte1Search');
        qte1Search.addEventListener('input', function(event){

            parseInt(qte1Search.value)<1?qte1Search.value=1:'';

            let qteTotal = document.querySelector('#qteSearch');
            let btn = document.querySelector('#addProduit');

            parseInt(qte1Search.value)>parseInt(qteTotal.value)?btn.disabled=true:btn.disabled=false;

            const totalSearch= document.querySelector('#totalSearch');
            const prixSearch= document.querySelector('#prixSearch');
            totalSearch.value=parseInt(qte1Search.value)*parseFloat(prixSearch.value);
        });


        //Mise a jour du total d'une ligne dans la liste des produits
        function handleInputChange(event) {
                const ChangedInput = event.target;
                const value=parseFloat(ChangedInput.value);
                const tr = (ChangedInput.parentElement).parentElement;
                const prix = parseFloat(tr.querySelector('#prix').innerHTML);
                const prixTotal = tr.querySelector('#prixTotal');
                if(value>0){
                    prixTotal.innerHTML=value*prix;

                    //Mise a jour du local storage
                    const code=tr.querySelector('#codePro').innerHTML;
                    const codePro=code.substring(0,3)+code.substring(4);

                    let stringArray = localStorage.getItem("cartBanbino");
                    myArray = JSON.parse(stringArray);

                    for (let i = 0; i < myArray.length; i++) {
                        const obj = myArray[i];
                        if (obj["codePro"] === codePro) {
                            obj['qte']=value;
                            break;
                        }
                    }
                    localStorage.setItem("cartBanbino", JSON.stringify(myArray));


                    totalFac();
                }else{
                    ChangedInput.value=1;
                    prixTotal.innerHTML=prix;
                }


        }


        //Supprimer les elements du panier
        function handlePanierDel(event){

            const btn = event.target;
            const tr = (btn.parentElement).parentElement;
            const code = tr.querySelector('#codePro').innerHTML;
            const codePro=code.substring(0,3)+code.substring(4);

            let stringArray = localStorage.getItem("cartBanbino");
            myArray = JSON.parse(stringArray);

            // Remove the object with the matching codePro
            for (let i = 0; i < myArray.length; i++) {
                const obj = myArray[i];
                if (obj["codePro"] === codePro) {

                    myArray.splice(i, 1); // Remove the object at index i
                    localStorage.setItem("cartBanbino", JSON.stringify(myArray));
                    break;

                }
            }

            //On affiche les produits
            afficherProduits();
            totalFac();
        }


        const submitButtons = document.querySelectorAll('.btn2');
        submitButtons.forEach(function(submitButton, index) {
        submitButton.addEventListener('click', handlePanierDel); // Attach the click event listener
          });


        //Afficher les elements du local storage
        function afficherProduits(){
            table.innerHTML="";
            let stringArray = localStorage.getItem("cartBanbino");
            myArray = JSON.parse(stringArray);
            myArray.forEach(function(line, index) {
                const tr=`<tr>
                        <th scope="row" >
                        <img src="${line["image"]}" alt="" style="border-radius: 5px;max-width: 60px;">
                        </th>
                        <td class="text-center align-middle" id="codePro" >${line["codePro"].substring(0,3)}-${line["codePro"].substring(3)}</td>

                        <td class="text-center align-middle">${line["qteDispo"]}</td>
                        <td class="text-center align-middle" id="prix">${line["prix"]}</td>
                        <td class="text-center align-middle">
                            <input class="form-label border-0 bg-light text-center qteInArray" value="${line["qte"]}" type="number"/>
                            <input type="number" value="${line["codePro"]}" name="codePro" style="display:none;"/>
                        </td>
                        <td class="text-center align-middle" id="prixTotal">${line["prix"]*line["qte"]}</td>
                        <th scope="row" class="text-center align-middle"><i class="bi bi-trash btn btn2"></i></th>
                        </tr>`
                const table = document.getElementById("table");
                table.innerHTML+=tr;
            });

            //Modification de la quantite d'une ligne
            const inputs=document.querySelectorAll('.qteInArray');
            inputs.forEach(function(input, index) {
                input.addEventListener('input', handleInputChange);
            });

            //Suppression d'un produit
            const delButtons = document.querySelectorAll('.btn2');
            delButtons.forEach(function(delButton, index) {
                delButton.addEventListener('click', handlePanierDel); // Attach the click event listener
            });


            //Filtre

            const elementsDUTableau = document.querySelectorAll('tr');

            //Pour la manipulation
            const trs=[...elementsDUTableau]
            // On supprime l'en - tete
            trs.shift();

            let searchBtn = document.querySelector('#search');

            function modifyTable(event){
              let search = event.target.value;
              let tbody=document.querySelector('tbody');
              tbody.innerHTML='';
              trs.forEach(function(tr, index) {
                const codePro = tr.querySelector('input[name="codePro"]').value;

                if(codePro.includes(search)){
                  tbody.appendChild(tr)
                }
                });


            }
            searchBtn.addEventListener('input', modifyTable);
        }


        //Ajout d'un produit a la facture
        let btn = document.querySelector('#addProduit');
        btn.addEventListener('click', function(event){
            const qte= parseInt(document.querySelector('#qte1Search').value);
            const qteTotal= document.querySelector('#qteSearch').value;
            const code= document.querySelector('#codeSearch').value;
            const prix= document.querySelector('#prixSearch').value;
            const images = document.querySelectorAll('.image');
            let src="";
            images.length>0?src=images[0].src:src="images/1719827982284.jpg";
            //Ajouter au local storage
            const myJsonObject = {
            "codePro": code.substring(0,3)+code.substring(4),
            "qte": qte,
            "prix": prix,
            "qteDispo":qteTotal,
            "image":src
            };
            let myArray = [];
            if (localStorage.getItem("cartBanbino")) {
                let stringArray = localStorage.getItem("cartBanbino");
                myArray = JSON.parse(stringArray);

                // Remove the object with the matching codePro
                for (let i = 0; i < myArray.length; i++) {
                    const obj = myArray[i];
                    if (obj["codePro"] === myJsonObject["codePro"]) {
                        console.log(myJsonObject["qte"])
                        myJsonObject["qte"]+=parseInt(obj["qte"]);
                        myArray.splice(i, 1); // Remove the object at index i

                    }
                }

            } else {
                // Create a new empty array
                myArray = [];
            }
            myArray.push(myJsonObject);
            localStorage.setItem("cartBanbino", JSON.stringify(myArray));
            //Affichage des produits
            afficherProduits();
            totalFac();
        });

        //vider le panier
        function handlePanierVide(event) {
            myArray = [];
            localStorage.setItem("cartBanbino", JSON.stringify(myArray));
            afficherProduits();
            totalFac();
        }
         const submitButton = document.querySelector('#viderPanier');
        submitButton.addEventListener('click', handlePanierVide);


    </script>

    <!-- Validation de la facture (element du fond, montant, remise ...) -->
    <script>

      function netPaye(){
          const montant = document.querySelector('#montantTotal');
          const remise = document.querySelector('#remise');
          const tva = document.querySelector('#tva');
          const netPaye = document.querySelector('#netPaye');

          const remiseValeur=parseFloat(remise.value);
          netPaye.value=(parseFloat(montant.value)*(1-parseFloat(remise.value)/100))*(1+parseFloat(tva.value)/100)
      }

      function totalFac(){

        const montant = document.querySelector('#montantTotal');
        montant.value=0;
        if (localStorage.getItem("cartBanbino")) {
            let stringArray = localStorage.getItem("cartBanbino");
            let myArray = JSON.parse(stringArray);

            for (let i = 0; i < myArray.length; i++) {
                const obj = myArray[i];
                montant.value=parseFloat(montant.value)+parseFloat(obj["qte"])*parseFloat(obj["prix"]);

            }


        }
        netPaye();
      }



      const remise = document.querySelector('#remise');
      remise.addEventListener('input',netPaye)
      const tva = document.querySelector('#tva');
      tva.addEventListener('input',netPaye)

      //Premier affichage
      afficherProduits();
      totalFac();
    </script>


    <!-- Form submit-->
    <script>
      const form= document.getElementById('formSubmit');
      form.addEventListener('submit',function(e){
        e.preventDefault();

        const form = document.querySelector("#formSubmit");
        const remise = form.querySelector('input[name="remise"]');
        const ligneFacture = form.querySelector('input[name="ligneFacture"]');
        const tva = form.querySelector('input[name="tva"]');

        remise.value = document.querySelector('#remise').value?document.querySelector('#remise').value:0;
        tva.value = document.querySelector('#tva').value?document.querySelector('#tva').value:0;

        let stringArray = localStorage.getItem("cartBanbino");
        let myArray = JSON.parse(stringArray);

        ligneFacture.value=JSON.stringify(myArray);

         handlePanierVide();

        form.submit();
      })
    </script>


</x-layaout>
