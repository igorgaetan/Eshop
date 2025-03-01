<x-layaout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Clients</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Client</li>
                <li class="breadcrumb-item active">Nouveau</li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="card">
                    
                    <div class="card-body">
                    
                      <h5 class="card-title"> Nouveau Client </h5>
                      
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

                      <form action="{{ route('client.store') }}" method="POST" >

                            @csrf
                            <div class="form-group mb-3">
                                <label
                                  for="matr"
                                  >Matricule
                                </label>
                                
                                <input
                                value="{{fake()->unique()->randomNumber(6, true)}}"
                                name="matr"
                                type="number"
                                class="form-control validate"
                                required
                              />
                              
                                
                            </div>
                            <div class="form-group mb-3">
                              <label
                                for="nom"
                                >Nom
                              </label>
                              <input
                                
                                name="nom"
                                type="text"
                                class="form-control validate"
                                value="{{request()->nom}}"
                                required
                              />
                            </div>
                            <div class="row">
                                <div class="form-group mb-3 col-xs-12 col-sm-6">
                                    <label
                                    for="dateNaiss"
                                    >Date NAISSANCE</label
                                  >
                                  <input
                                    
                                    name="dateNaiss"
                                    type="date"
                                    class="form-control validate"
                                    value="{{request()->dateNaiss}}"
                                    required
                                  />
                                  </div>
                                  <div class="form-group mb-3 col-xs-12 col-sm-6">
                                    <label
                                    for="whatsapp"
                                    >Sexe
                                    </label>
                                    <select class="form-select" aria-label="Default select example" name='sexe'>
                                      <option selected value="1">Homme</option>
                                      <option value="0">Femme</option>
                                    </select>
                                  </div>
                            </div>
                            
                            <div class="form-group mb-3">
                              <label
                                for="category"
                                >Ville</label
                              >
                              <select class="form-select" aria-label="Default select example" name="ville_id" required>
                                <option value="" selected disabled> --- </option>
                                @foreach ($villes as $ville)
                                  <option value="{{$ville->id}}">{{$ville->libelle}}</option>
                                  
                                @endforeach   
                              </select>
                            </div>
                            <div class="row">
                                <div class="form-group mb-3 col-xs-12 col-sm-6">
                                    <label
                                      for="mobile"
                                      >Mobile
                                    </label>
                                   
                                        <input
                                        
                                        name="mobile"
                                        type="text"
                                        class="form-control validate"
                                        value="{{request()->mobile}}"
                                        required
                                        />
                                  </div>
                                  <div class="form-group mb-3 col-xs-12 col-sm-6">
                                    <label
                                    for="whatsapp"
                                    >Whatsapp
                                    </label>
                                    <select class="form-select" aria-label="Default select example" name='whatsapp'>
                                      <option selected value="1">Oui</option>
                                      <option value="0">Non</option>
                                    </select>
                                  </div>
                            </div>                                       
                            <button type="submit" class="btn btn-primary w-100">Creer la Carte Client</button>
                      </form>
                    </div>
                </div>
              </div>
              
              <div class="col-12 col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title"> Nouvelle ville </h5>
                    
                    <form action="{{ route('createVille') }}" method="POST" >
                      @csrf
                      <div class="form-group mb-3">
                              <label
                                for="libelle"
                                >Nom
                              </label>
                              <input
                                name="libelle"
                                type="text"
                                class="form-control validate"
                                required
                              />
                      </div>
                    
                      <button type="submit" class="btn btn-primary w-100">Creer la ville</button>
                    </form>
                  </div>
                
                </div>
              
              </div>
            </div>
          </section>
      
    </main>
</x-layaout>