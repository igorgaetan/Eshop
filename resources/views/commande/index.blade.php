<x-layaout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Commandes</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Liste</li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">
             <!-- Modal pour la date-->
            <div class="modal fade" id="date" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title">Selectionner un interval de temps</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form>
                      <input type="hidden" name="search" value="interval">
                      <div class="modal-body row">
                              <input type="hidden" name="search" value="interval"/>
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                                  <label
                                  for="date1"
                                  >Debut
                                  </label>
                                  <input
                                  name="date1"
                                  type="date"
                                  class="form-control validate"
                                  required
                                  />
                              </div>
                              <div class="form-group mb-3 col-xs-12 col-sm-6">
                                  <label
                                  for="prix"
                                  >Fin
                                  </label>
                                  <input

                                  name="date2"
                                  type="date"
                                  class="form-control validate"
                                  required
                                  />
                              </div>

                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Rechercher</button>
                      </div>
                  </form>
                </div>
              </div>
          </div>

          <div class="card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                  <h6>Filter</h6>
              </li>

              <li>
                  <form>
                      <button class="dropdown-item"type="submit">Today</button>
                  </form>

              </li>
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#date">Choisir une periode</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Liste des commandes
                <span>|
                  @if(request()->search=='interval')
                      Du {{request()->date1}} Au {{request()->date2}}
                  @else
                      Aujourd'hui
                  @endif
                </span>
            </h5>
              <table class="table datatable">
                  <thead>
                      <tr>

                          <th scope="col" class="text-center align-middle">NO</th>
                          <th scope="col" class="text-center align-middle">Montant</th>
                          <th scope="col" class="text-center align-middle">Client</th>
                          <th scope="col" class="text-center align-middle">Mobile</th>

                          <th scope="col" class="text-center align-middle">Ville</th>
                          <th scope="col" class="text-center align-middle">Traitement</th>
                          <th scope="col" class="text-center align-middle">Livré?</th>
                          <th scope="col" class="text-center align-middle">Date</th>
                          <th scope="col">&nbsp;</th>
                        </tr>
                  </thead>

                  <tbody>
                      @forelse ($commandes as $commande)

                      <tr>

                          <td class="text-center align-middle"><a href="{{route('commande.show',['commande'=>$commande])}}" style="text-decoration: none; color:black;">{{$commande->id}}</a></td>
                          <td class="text-center align-middle">{{formateur($commande->montant)}}</td>
                          <td class="text-center align-middle">{{$commande->nomClient}}</td>
                          <td class="text-center align-middle">{{$commande->mobile}}</td>

                          <td class="text-center align-middle">{{$commande->ville->libelle}}</td>
                          <td class="text-center align-middle">
                            @if ($commande->type==0)
                            <span class="badge bg-danger"> En attente </span>

                            @elseif ($commande->type==1)
                              <span class="badge bg-primary"> En cours </span>

                            @elseif ($commande->type == 2)
                              <span class="badge bg-secondary">En attente de livraison </span>
                            @elseif ($commande->type==3)
                              <span class="badge bg-warning">En attente de facturation </span>
                            @else
                              <span class="badge bg-success">Terminer</span>
                            @endif
                          </td>
                          <td class="text-center align-middle">
                              @if ($commande->livrer==0)
                                <span class="badge bg-info">  Non </span>

                              @elseif ($commande->livrer==1)
                                <span class="badge bg-success">  Oui</span>

                              @elseif ($commande->livrer==2)
                                <span class="badge bg-success"> Reserver</span>
                              @endif
                          </td>
                          <td class="text-center align-middle">{{$commande->created_at->format('d-m-Y H:i:s')}} </td>

                          <td class="text-center align-middle">

                            <a href="{{route('commande.show',['commande'=>$commande])}}" class=""><span class="badge bg-primary"> Voir plus </span></a>

                          </td>




                      </tr>
                      @empty
                      <p class="text-slate-400 text-center"> Aucun resultat </p>
                      @endforelse
                  </tbody>
                </table>
            </div>



          </div>

        </section>

    </main>
</x-layaout>
