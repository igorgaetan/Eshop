<x-layaout>
    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Creation d'un Nouveau produits</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item">Produits</li>
              <li class="breadcrumb-item active">Nouveau</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->
    
        <section class="section">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
    
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Veuillez remplir le formulaire</h5>
    
                  <form action="{{route('produits.store')}}" method="POST" class="pb-3">
                    @csrf
                    @if ($errors->any())
                      <div class="alert alert-danger mb-3">
                        <ul>
                          @foreach ($errors->all() as $error)
                            <li class="text-danger">{{$error}}</li> 
                          @endforeach
                        </ul>
                      </div>
                    @endif
                    <div class="form-group mb-3">
                        <label
                          for="codePro"
                          >Code Produit
                        </label>
                        <input
                          value="{{fake()->unique()->randomNumber(6, true)}}"
                          name="codePro"
                          type="number"
                          class="form-control validate"
                          required
                        />
                    </div>
                    <div class="form-group mb-3">
                      <label
                        for="nomPro"
                        >Nom du produit
                      </label>
                      <input
                        name="nomPro"
                        type="text"
                        class="form-control validate"
                        
                        required
                      />
                    </div>
                    <div class="form-group mb-3">
                      <label
                        for="description"
                        >Description</label
                      >
                      
                      <textarea
                        class="form-control validate"
                        rows="3"
                        style="height: 110px;"
                        name="description"
                        required
                      ></textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                      <label
                        for="category"
                        >Categorie</label
                      >
                      <select class="form-select" aria-label="Default select example" name="categorie_id" required>
                        
                          <option value="" disabled selected>---</option>
                          @forelse ($categories as $categorie)
                            <option value="{{$categorie->id}}">{{$categorie->nomCat}}</option>
                            @empty
                            
                          @endforelse  
                           
                        
                      </select>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                            <label
                              for="prixAchat"
                              >Prix achat
                            </label>
                            <input
                              name="prixAchat"
                              type="number"
                              class="form-control validate"
                              required
                            />
                          </div>
                          <div class="form-group mb-3 col-xs-12 col-sm-6">
                            <label
                              for="prix"
                              >Prix vente
                            </label>
                            <input
                              
                              name="prix"
                              type="number"
                              class="form-control validate"
                              required
                            />
                          </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                            <label
                              for="codeArrivage"
                              >Code Arrivage
                            </label>
                            <input
                              name="codeArrivage"
                              type="text"
                              class="form-control validate"
                              required
                              
                            />
                          </div>
                          <div class="form-group mb-3 col-xs-12 col-sm-6">
                            <label
                            for="qte"
                            >Quantite
                            </label>
                            <input
                              value="0"
                              name="qte"
                              type="number"
                              class="form-control validate"
                              disabled
                            />
                          </div>
                    </div>
                    <div class="row">
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                          <label
                            for="actif"
                            >Actif
                          </label>
                          <select class="form-select" aria-label="Default select example" name='actif'>
                            <option selected value="1">OUI</option>
                            <option value="0">Non</option>
                            
                          </select>
                        </div>
                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                          <label
                          for="promo"
                          >En promo
                          </label>
                          <select class="form-select" aria-label="Default select example" name='promo'>
                            <option selected value="0">Non</option>
                            <option value="1">Oui</option>
                          </select>
                        </div>
                      </div>

                    
                      <div class="col-12 p-3">
                        <button type="submit" class="btn btn-primary  text-white w-100">Creer le produit</button>
                      </div>
                    </div>
                
				
				</form>
                </div>
              </div>
    
            </div>
    
        </section>
    
      </main><!-- End #main -->
    
</x-layaout>