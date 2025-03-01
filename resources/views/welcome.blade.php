<x-layaout>
    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Tableau de bord</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('index')}}">Accueil</a></li>
            </ol>
          </nav>
        </div><!-- End Page Title -->

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

            <div class="row">

                <!-- Revenue-->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>

                        <li>
                            <form>
                                <button class="dropdown-item"type="submit">Aujourd'hui</button>
                            </form>

                        </li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#date">Choisir une periode</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Recette<span>|
                        @if(isset(request()->date1) && isset(request()->date2))
                            Du {{request()->date1}} Au {{request()->date2}}
                        @else
                            Aujourd'hui
                        @endif</span></h5>

                        <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{formateur($recette)}}</h6>
                            <span class="text-success small pt-1 fw-bold">{{$factures->count()}}</span> <span class="text-muted small pt-2 ps-1">Factures</span>

                        </div>
                        </div>
                    </div>

                    </div>
                </div>

                <!--Net percu-->
                <div class="col-xxl-4 col-md-6">

                    <div class="card info-card customers-card">


                    <div class="card-body">
                        <h5 class="card-title">Net Percu
                            <span>|
                                @if(request()->search=='interval')
                                    Du {{request()->date1}} Au {{request()->date2}}
                                @else
                                    Aujourd'hui
                                @endif
                            </span>
                        </h5>


                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{formateur($netPercu)}}</h6>
                                <span class="text-success small pt-1 fw-bold">
                                    @if($recette>0)
                                    {{round((1-$netPercu/$recette)*100,2)}}  % de remise
                                    @else
                                    0 % de remise
                                    @endif
                                </span>
                                <span class="text-muted small pt-2 ps-1"></span>

                            </div>
                        </div>

                    </div>
                    </div>

                </div>

                <!--capitals-->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                    <div class="card-body">
                        <h5 class="card-title">Capital <span>|
                            @if(request()->search=='interval')
                                Du {{request()->date1}} Au {{request()->date2}}
                            @else
                                Aujourd'hui
                            @endif
                        </span></h5>

                        <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{formateur($capital)}}</h6>
                            <span class="text-success small pt-1 fw-bold"> en {{config('app.device')}} </span> <span class="text-muted small pt-2 ps-1"></span>

                        </div>
                        </div>
                    </div>

                    </div>
                </div>

                <!-- Nombre de client-->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                        <h5 class="card-title">Total client <span>|
                            @if(request()->search=='interval')
                                Du {{request()->date1}} Au {{request()->date2}}
                            @else
                                Aujourd'hui
                            @endif
                        </span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                            <h6>{{$nombreCustumer}}</h6>
                            <span class="text-success small pt-1 fw-bold">  </span> <span class="text-muted small pt-2 ps-1"></span>

                            </div>
                        </div>
                        </div>

                    </div>
                </div>



                <!-- Top Selling -->
                <div class="col-12">
                    <div class="card overflow-auto">


                    <div class="card-body pb-0">
                        <h5 class="card-title">Dernieres factures <span>|
                            @if(request()->search=='interval')
                                Du {{request()->date1}} Au {{request()->date2}}
                            @else
                                Aujourd'hui
                            @endif
                        </span></h5>

                        <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col"  class="text-center">Code</th>
                                <th scope="col" class="text-center">Montant</th>
                                <th scope="col" class="text-center">Capital</th>
                                <th scope="col" class="text-center">Remise</th>
                                <th scope="col" class="text-center">Net</th>
                                <th scope="col" class="text-center">Paiement</th>
                                <th scope="col" class="text-center">Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factures as $facture)
                                <tr>

                                    <td class="text-center"><a href="{{route('facture.edit',['facture'=>$facture])}}">#{{$facture->id}}</a></a></td>
                                    <td class="text-center">{{formateur($facture->montant)}}</td>
                                    <td class="text-center">{{formateur($facture->capital)}}</td>
                                    <td class="text-center">{{$facture->remise}}</td>
                                    <td class="text-center">{{formateur((1-$facture->remise/100)*$facture->montant)}}</td>
                                    <td class="text-center">
                                        @if ($facture->typeFac==0)
                                        <span class="badge bg-success">Cash</span>

                                        @elseif ($facture->typeFac==1)
                                        <span class="badge bg-primary">Tontine</span>

                                        @elseif ($facture->typeFac==2)
                                        <span class="badge bg-info">Bon achat</span>

                                        @elseif ($facture->typeFac==3)
                                        <span class="badge bg-danger">OM</span>

                                        @elseif ($facture->typeFac==4)
                                        <span class="badge bg-dark text-white">Momo</span>

                                        @elseif ($facture->typeFac==5)
                                        <span class="badge bg-warning">Autre</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{$facture->updated_at->format('d-m-Y')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>

                    </div>

                    </div>
                </div><!-- End Top Selling -->



            </div>
        </section>

      </main><!-- End #main -->

</x-layaout>
