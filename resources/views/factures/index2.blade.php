<x-layaout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Factures</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Factures</li>
                <li class="breadcrumb-item active">En attente</li>
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
                      <div class="modal-body row">
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


              <div class="col-lg-12">
                <div class="card">

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

                  <div class="card-body overflow-auto">
                    <h5 class="card-title">Listes des factures
                    </h5>

                    @if(auth()->user()->typeGest==0)
                    <p class="text-end">
                      <button class="btn link-primary" onclick="exportTableToExcel('myTable', 'ListeFacture')">Exporter vers Excel</button>
                    </p>
                    @endif

                    <table class="table datatable">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center align-middle">ID</th>
                          <th scope="col" class="text-center align-middle">Montant</th>

                          <th scope="col" class="text-center align-middle">Date</th>
                          <th scope="col" class="text-center align-middle">Type</th>
                          <th scope="col" class="text-center align-middle">CAISSIER</th>
                          @can('create and edit invoices')
                          <th scope="col">&nbsp;</th>
                          @endcan
                        </tr>
                      </thead>

                      <tbody>
                          @foreach($factures as $facture)
                          <tr>
                            <th scope="row" class="text-center align-middle"><a href="{{route('facture.edit',['facture'=>$facture])}}">#{{$facture->id}}</a></th>
                            <td class="text-center align-middle">{{formateur($facture->montant)}}</td>


                            <td class="text-center align-middle">{{$facture->created_at->format('d-m-Y')}}</td>
                            <td class="text-center align-middle">

                              @if($facture->paiementValid==1)
                                <span class="badge bg-success">
                                  @if ($facture->typeFac==0)
                                    Cash

                                  @elseif ($facture->typeFac==1)
                                  Tontine

                                  @elseif ($facture->typeFac==2)
                                    Bon achat

                                  @elseif ($facture->typeFac==3)
                                    OM

                                  @elseif ($facture->typeFac==4)
                                    Momo

                                  @elseif ($facture->typeFac==5)
                                    Autre
                                  @endif
                                </span>
                              @else
                                <span class="badge bg-warning">
                                  @if ($facture->typeFac==0)
                                    Cash

                                  @elseif ($facture->typeFac==1)
                                  Tontine

                                  @elseif ($facture->typeFac==2)
                                    Bon achat

                                  @elseif ($facture->typeFac==3)
                                    OM

                                  @elseif ($facture->typeFac==4)
                                    Momo

                                  @elseif ($facture->typeFac==5)
                                    Autre
                                  @endif
                                </span>
                              @endif
                            </td>
                            <td class="text-center align-middle">

                              {{$facture->user->nomGest}}

                            </td>
                            @can('create and edit invoices')
                              <td>
                                @if(!$facture->paiementValid)
                                  <form action="{{route('destroyFac',['facture'=>$facture])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn text-danger" type="submit" ><i class="bi bi-trash"></i></button>
                                  </form>
                                @else
                                    <button class="btn text-light" type="submit" ><i class="bi bi-trash"></i></button>
                                @endif
                              </td>
                            @endcan
                          </tr>
                        @endforeach

                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            </div>
        </section>

    </main>

      <table id="myTable" border="1" class="d-none">
          <tr>
              <th>ID</th>
              <th>Montant</th>
              <th>Remise</th>
              <th>Tva</th>
              <th>Net percu</th>
              <th>Date</th>
              <th>Paiement</th>
              <th>Caissier</th>
              <th> Etat </th>
          </tr>
          @foreach($factures as $facture)
            <tr>
                <td>{{formateur($facture->id)}}</td>
                <td>{{formateur($facture->montant)}}</td>
                <td>{{formateur($facture->remise)}}</td>
                <td>{{formateur($facture->tva)}}</td>
                <td>{{formateur(($facture->montant*(1-$facture->remise/100))*(1+$facture->tva/100))}}</td>
                <td>{{$facture->created_at->format('d-m-Y H:i:s')}}</td>
                <td> @if ($facture->typeFac==0)
                      Cash
                    @elseif ($facture->typeFac==1)
                      Tontine
                    @elseif ($facture->typeFac==2)
                      Bon achat
                    @elseif ($facture->typeFac==3)
                      OM
                    @elseif ($facture->typeFac==4)
                      Momo
                    @elseif ($facture->typeFac==5)
                      Autre
                    @endif
                </td>
                <td class="text-center align-middle">
                  {{$facture->user->nomGest}}
                </td>
                <td class="text-center align-middle">
                  @if($facture->paiementValid)
                    Terminé
                  @else
                   En attente
                  @endif
                </td>
            </tr>
          @endforeach

      </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
     <script>
        function exportTableToExcel(tableID, filename = '') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Nom du fichier
            filename = filename ? filename + '.xls' : 'tableau.xls';

            // Création du lien de téléchargement
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Crée un lien et déclenche le téléchargement
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Nom du fichier
                downloadLink.download = filename;

                // Déclenche le téléchargement
                downloadLink.click();
            }
        }
    </script>

</x-layaout>
