<x-layaout>
  <main id="main" class="main">

     


    <div class="pagetitle">
        <h1>
          Facture    
        </h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
            <li class="breadcrumb-item">Factures no {{$facture->id}}</li>
            <li class="breadcrumb-item active">
                Nouveau produit
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
                          <form action="{{route('facture.storeLigneFac',["facture"=>$facture])}}" id="formSubmit" method="POST">
                                @csrf
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
                                        <input type="number" name="qte"  id="qte1Search" value="1" class="form-control validate">
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
                         
                                <button type="submit" class="btn bg-primary bg-opacity-50  text-white w-100" id="addProduit" disabled> Ajouter </button>
                      
                            </form>

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

  
    <script>
        const form= document.getElementById('formSubmit');
        form.addEventListener('submit',function(e){
            e.preventDefault();

            const form = document.querySelector("#formSubmit");
            const codePro = form.querySelector('input[name="codePro"]');

            const code=codePro.value;
            codePro.value=code.substring(0,3)+code.substring(4);
            console.log(codePro.value)
            
            form.submit();
        })
    </script>
  
  
</x-layaout>