<x-layaout>
    <main id="main" class="main">
      <div class="pagetitle">
          <h1>
            Produits
          </h1>
          <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
              <li class="breadcrumb-item">Produits</li>
              <li class="breadcrumb-item active">
                  Rechercher
              </li>
          </ol>
          </nav>
      </div>

        <section class="section dashboard">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Entrer le code du produit
                            </h5>
                            <form action="{{route('produits.audit')}}" method="POST">
                                  @csrf

                                  @if ($errors->any())
                                    <div class="alert alert-danger mb-3">

                                    @foreach ($errors->all() as $error)
                                      {{$error}}
                                    @endforeach

                                    </div>
                                  @endif
                                  <div class="row ">
                                      <div class="col-12 mb-3">
                                          <label
                                          >Code
                                          </label>
                                          <input name="codePro" type="search" class="form-control validate" value="{{request()->codePro}}" required>
                                      </div>
                                      <input type="hidden" name="details" value="true"/>

                                  </div>

                                    <button type="submit" class="btn btn-primary w-100" id="addProduit"> Rechercher </button>

                              </form>

                        </div>
                    </div>
                </div>

            </div>



        </section>

    </main>




  </x-layaout>
