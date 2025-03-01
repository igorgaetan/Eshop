<x-layaout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Utilisateurs</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Utilisateur</li>
                <li class="breadcrumb-item active">New</li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
      

              <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    
                    <div class="card-body">
                        <h5 class="card-title">Nouvel Utilisateur</h5>
                        <form action="{{ route('user.store') }}" method="POST" >
                            @csrf
                            @if ($errors->any())
                              <div class="form-group mb-3">
                                <ul>
                                  @foreach ($errors->all() as $error)
                                    {{$error}}
                                  @endforeach
                                </ul>
                              </div>
                            @endif
                            <div class="form-group mb-3">
                                <label
                                  for="nomGest"
                                  >Noms
                                </label>
                                <input
                            
                                  name="nomGest"
                                  type="text"
                                  class="form-control validate"
                                  required
                                />
                            </div>
                            <div class="form-group mb-3">
                              <label
                                for="login"
                                >Login
                              </label>
                              <input
                                name="login"
                                type="text"
                                class="form-control validate"
                                required
                              />
                            </div>
                            <div class="form-group mb-3">
                              <label
                                for="password"
                                >Password
                              </label>
                              <input
                                name="password"
                                type="password"
                                class="form-control validate"
                                required
                              />
                            </div>
                            <div class="form-group mb-3">
                              <label
                                for="mobile"
                                >Mobile
                              </label>
                              <input
                                name="mobile"
                                type="text"
                                class="form-control validate"
                                required
                              />
                            </div>
                            
                       
                         
           
                            <div class="form-group mb-3">
                              <label
                                for="typeGest"
                                >Type d'Utilisateur
                                </label>
                                <select class="form-select" aria-label="Default select example" name='typeGest'>
                                <option selected value="2">Magasinier</option>
                                <option value="1">Caissier</option>
                                <option value="3">Vendeur</option>
                                <option value="5">Financier</option>
                                <option value="4">Auditeur</option>
                                </select>
                                
                            </div>
                            <!--<button type="submit" class="btn bg-primary bg-opacity-50  text-white w-100">Creer l'Utilisateur</button>-->
                            <button type="submit" class="btn bg-primary bg-opacity-50 text-white w-100">Creer l'Utilisateur</button>

                      </form>
                    </div>
                  </div>
              </div>
      
          
      
            </div>
          </section>
      
    </main>
</x-layaout>