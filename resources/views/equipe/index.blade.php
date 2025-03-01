<x-layaout>

    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Liste des Utilisateurs</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index1.html">Home</a></li>
              <li class="breadcrumb-item">Utilisateurs</li>
              <li class="breadcrumb-item active">Liste</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->
    
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
    
              <div class="card">
                <div class="card-body">
                 
                  <h5 class="card-title">Liste des produits</h5>
                  <!-- Table with stripped rows -->
                  <table class="table datatable">
                    <thead>
                      <tr>
                    
                        <th> Nom </th>
                        <th> Login</th>
                        <th>Mobile</th>
                        <th>Type</th>
                        <th>ACTION</th>
                        
                       
                      
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            
                            <td>{{$user->nomGest}}</td>
                            <td>{{$user->login}}</td>
                            <td>{{$user->mobile}}</td>

                            <td>
                            @if ($user->typeGest==1)
                            Caissier
                            @elseif ($user->typeGest==0)
                            Administrateur
                            @elseif ($user->typeGest==2)
                            Magasinier
                            @elseif ($user->typeGest==3)
                            Vendeur
                            @elseif ($user->typeGest==4)
                            Auditeur
                            @elseif ($user->typeGest==5)
                            Financier
                            @endif
                            </td>
                            <td><a href={{route('user.edit',['user'=>$user])}}>modifier </a></td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <!-- End Table with stripped rows -->
                 
                </div>
              </div>
    
            </div>
          </div>
        </section>
    
      </main><!-- End #main -->
    
</x-layaout>