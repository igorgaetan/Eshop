<x-layaout>

    <!-- tontine show-->
    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Tontine ID :  <span class="fw-bold" id="id_fac"> </span> </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="details-tontine">   
                    
                  <div class="form-group mb-3">
                    <label
                      for="montant"
                      >Montant
                    </label>
                    <input
                      name="montant"
                      type="number"
                      class="form-control validate"
                      disabled
                    />
                  </div>
                  <div class="mb-3">
                    <label for="commentaire" class="col-form-label">Commentaire:</label>
                    <textarea class="form-control" id="message-text" name="commentaire"></textarea>
                  </div>
                  <div class="row">
                    <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="action"
                          >Action
                        </label>
                        <select class="form-select" aria-label="Default select example" name="action" disabled>
                          <option selected value="1">Depot</option>
                          <option  value="0">Retrait</option>
                          
                      </select>
                    </div>
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                        <label
                          for="validite"
                          >Validité 
                        </label>
                        <select class="form-select" aria-label="Default select example" name="validite" disabled>
                            <option selected value="1">Valide</option>
                            <option  value="0">Invalide</option>
                            
                        </select>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Terminer</button>
            </div>
          </div>
        </div>
    </div>
    </div>
    
    
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Clients</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Client</li>
                <li class="breadcrumb-item active" >Tontine</li>
            </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
      

              <div class="col-lg-12">
                <div class="card">
                    <div class="card-body overflow-auto">
                        <h5 class="card-title">Liste des tontines </h5>
                         @if(auth()->user()->typeGest==0)
                            <p class="text-end">
                              <button class="btn link-primary" onclick="exportTableToExcel('myTable', 'ListeTontines')">Exporter vers Excel</button>
                            </p>
                          @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center align-middle" >ID</th>
                                    <th scope="col" class="text-center align-middle" >Montant</th>
                                    <th scope="col" class="text-center align-middle" >Action</th>
                                    <th scope="col" class="text-center align-middle" >Agent</th>
                                    <th scope="col" class="text-center align-middle" >Date</th>
                                    <th scope="col" class="text-center align-middle" >Client</th>
                                    <th scope="col" class="text-center align-middle" >Montant actuel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tontines as $tontine)
                                    <tr>
                                    
                                        <td class="text-center align-middle"><button class="btn btn1 text-info fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">{{$tontine->id}}</button></td>
                                        <td class="text-center align-middle">{{formateur($tontine->montant)}}</td>
                                        <td class="text-center align-middle">
                                            @if($tontine->action) 
                                                <span class="badge bg-primary">Depot</span>
                                            @else
                                                <span class="badge bg-success">Paiement</span>
                                            @endif
                                        </td>
                                        <input type="hidden" name="id" value="{{$tontine->id}}"/>
                                        <input type="hidden" name="montant" value="{{$tontine->montant}}"/>
                                        <input type="hidden" name="validite" value="{{$tontine->validite}}"/>
                                        <input type="hidden" name="action" value="{{$tontine->action}}"/>
                                        <input type="hidden" name="commentaire" value="{{$tontine->commentaire}}"/>
                                        <input type="hidden" name="user" value="{{$tontine->user->nomGest}}"/>
                                        
                                        
                                        <td class="text-center align-middle">{{$tontine->user->nomGest}}</td>
                                        <td class="text-center align-middle">{{$tontine->created_at->format('d-m-Y')}}</td>
                                        
                                        <td class="text-center align-middle"><a href="{{route('edit.clientCarte',['clientCarte'=>$tontine->clientCarte])}}">{{$tontine->clientCarte->nom}}</a></td>
                                        <td class="text-center align-middle">{{formateur($tontine->clientCarte->montantTontine)}}</td>
                                    
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                          
                          <p class="text-secondary mb-0 pb-0">{{$total}} Resultats </p>
                          <p class="text-secondary mb-0 pb-0"> 
                              @if($tontines->hasPages())
                                @if(request()->page)
                                  {{(request()->page-1)*25+1}} -- @if(request()->page*25>$total) {{$total}} @else {{request()->page*25}} @endif
                                  @else
                                  1 -- 25
                                  @endif
                              @else
                                @if($total>0)
                                 1 -- {{$total}}
                                @endif
                               @endif
                          </p>
                 
                         @if ($tontines->hasPages())
                          <ul class="pagination justify-content-center">
                              {{-- Previous Page Link --}}
                              @if ($tontines->onFirstPage())
                                  <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                              @else
                                  <li class="page-item"><a class="page-link" href="{{ $tontines->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                              @endif
                      
                              {{-- Pagination Elements --}}
                              @foreach ($tontines->links()->elements as $element)
                                  {{-- "Three Dots" Separator --}}
                                  @if (is_string($element))
                                      <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                  @endif
                      
                                  {{-- Array Of Links --}}
                                  @if (is_array($element))
                                      @foreach ($element as $page => $url)
                                          @if ($page == $tontines->currentPage())
                                              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                          @else
                                              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                          @endif
                                      @endforeach
                                  @endif
                              @endforeach
                      
                              {{-- Next Page Link --}}
                              @if ($tontines->hasMorePages())
                                  <li class="page-item"><a class="page-link" href="{{ $tontines->nextPageUrl() }}" rel="next">&raquo;</a></li>
                              @else
                                  <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                              @endif
                          </ul>
                          @endif
                    
                          
                    </div>
                </div>
              </div>
      
          
      
            </div>
          </section>
      
    </main>
    
    <script>
        function  showTontineDetail(event){
          const btn = event.target;
          const tr = ((btn.parentElement).parentElement);
          
          const div = document.getElementById('details-tontine');
          
          div.querySelector('input[name="montant"]').value=tr.querySelector('input[name="montant"]').value;
          div.querySelector('select[name="action"]').value=tr.querySelector('input[name="action"]').value;
          
          div.querySelector('select[name="validite"]').value=tr.querySelector('input[name="validite"]').value;
          
          div.querySelector('textarea[name="commentaire"]').value=tr.querySelector('input[name="commentaire"]').value;
        
          const span = document.getElementById("id_fac");
          span.innerHTML=tr.querySelector('input[name="id"]').value;
        }
  
            const submitButtons = document.querySelectorAll('.btn1');
        submitButtons.forEach(function(submitButton, index) {
        submitButton.addEventListener('click', showTontineDetail); 
            });
    </script>
    
    
     <table id="myTable" border="1" class="d-none">
          <tr>
                <th >ID</th>
                <th >Montant</th>
                <th >Action</th>
                <th >Agent</th>
                <th >Date</th>
                <th >Nom Client</th>
                <th >Tel Client</th>
                <th >Montant actuel</th>
          </tr>
          @foreach ($tontines as $tontine)
            <tr>
            
                <td class="text-center">{{$tontine->id}}</td>
                <td class="text-center">{{formateur($tontine->montant)}}</td>
                <td class="text-center">
                    @if($tontine->action) 
                        Depot
                    @else
                        Paiement
                    @endif
                </td>
                
                
                <td class="text-center">{{$tontine->user->nomGest}}</td>
                <td class="text-center">{{$tontine->created_at->format('d-m-Y')}}</td>
                <td class="text-center">{{$tontine->clientCarte->nom}}</td>
                <td class="text-center">{{$tontine->clientCarte->mobile}}</td>
                <td class="text-center">{{formateur($tontine->clientCarte->montantTontine)}}</td>
            
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