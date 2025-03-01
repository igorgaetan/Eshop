<x-layaout>
    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Commandes</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
              <li class="breadcrumb-item">Commande</li>
              <li class="breadcrumb-item active">Transporteurs</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->
    
        <section class="section">
            
          <div class="row"> 
          
              
              <!-- Categories list -->
              <div class="col-12 ml-0">
                  <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Vos transporteurs</h5>
                        
                       <table class="table datatable">
                          <thead>
                            <tr>
                              <th class="text-center">Ville</th>
                              <th class="text-center">
                                Agence
                              </th>
                              <th class="text-center">
                                Prix
                              </th>
                             <th class="text-center">
                                Tel 1
                              </th>
                             <th class="text-center">
                                Tel 2
                              </th>
                              <th class="text-center">
                                <i class="bi bi-trash3"></i>
                              </th>
                             
                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($transporteurs as $transporteur)
                              <tr>
                                  <td class="text-center align-middle">{{$transporteur->ville->libelle}}</td>
                                  <td class="text-center align-middle">{{$transporteur->transporteur}}</td>
                                  <td class="text-center align-middle">{{formateur($transporteur->prix)}}</td>
                                  <td class="text-center align-middle">{{$transporteur->mobile1}}</td>
                                  <td class="text-center align-middle">{{$transporteur->mobile2}}</td>
                                  <td class="text-center align-middle"> <form method="post" action="{{route('transporteurDestroy',['expedition'=>$transporteur])}}"> 
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger">
                                        <i class="bi bi-trash3"></i> </button> </form> </td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        
                        
                        <p class="text-secondary mb-0 pb-0">{{$total}} Resultats </p>
                      </div>
                    </div>
          
              </div><!-- End Categories list -->
  
              
              <!--  Categorie store -->
              <div class="col-md-6 ml-0">

                  
    
                  <div class="card px-2">
                      @if ($message = Session::get('success'))
                          <div class="alert alert-success mt-3">
                              <strong class="text-success">{{ $message }}</strong>
                          </div>
                      @endif
                      @if ($errors->any())
                          <div class="alert alert-danger m-3">
                          @foreach ($errors->all() as $error)
                              {{$error}}
                          @endforeach
                          </div>
                      @endif

                      
    
                      <div class="card-body">
                          <h5 class="card-title">Ajouter un transporteur</span></h5>
                          <form action="{{route('transporteurAdd')}}" method="POST" >
                              @csrf
                            <div class="form-group mb-3 ">
                              <label
                                >Nom
                              </label>
                              <input
                                name="transporteur"
                                type="text"
                                class="form-control validate"
                                required
                              />
                            </div>
                            <div class="form-group mb-3 ">
                              <label
                                >Prix
                              </label>
                              <input
                                name="prix"
                                type="number"
                                class="form-control validate"
                                required
                              />
                            </div>
                            <div class="form-group mb-3 ">
                              <label
                                
                                >Tel 1
                              </label>
                              <input
                                name="mobile1"
                                type="text"
                                class="form-control validate"
                                required
                              />
                            </div>
                            <div class="form-group mb-3 ">
                              <label
                                for="nomCat"
                                >Tel 2
                              </label>
                              <input
                                name="mobile2"
                                type="text"
                                class="form-control validate"
                                required
                              />
                            </div>
                             <div class="form-group mb-3 ">
                              <label
                                
                                >Ville
                              </label>
                              <select class="form-select" aria-label="Default select example" name="ville_id" required>
                                <option value="" selected disabled> --- </option>
                                @foreach ($villes as $ville)
                                  <option value="{{$ville->id}}">{{$ville->libelle}}</option>
                                  
                                @endforeach   
                              </select>
                            </div>
                           
                            <div class="dropdown mt-3">
                              <button type="submit" class="btn btn-primary btn-block  mb-3 w-100">
                                Creer la Transporteur
                              </button>
                            </div>
                            </form>
            
                      </div>
                      
    
                  </div>
              </div><!-- End Categorie edit -->
    
          </div>

          
        </section>
    
      </main><!-- End #main -->
    


</x-layaout>