<x-layaout>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">{{$user->nomGest}}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <img src="{{asset("images/profile-img.jpeg")}}" alt="Profile" class="rounded-circle">
                    <h2>{{$user->nomGest}}</h2>
                    <h3>
                        @if ($user->typeGest==1)
                            Caissier
                        @elseif ($user->typeGest==2)
                            Magasinier
                        @elseif ($user->typeGest==3)
                            Vendeur
                        @elseif ($user->typeGest==4)
                            Auditeur
                        @elseif ($user->typeGest==5)
                            Financier
                        @else
                            Administrateur
                        @endif
                    </h3>
                    
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                    <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>

                    <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                    </li>

                    <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Activité</button>
                    </li>

                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        
                        <h5 class="card-title">Profile Details</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                            
                            @foreach ($errors->all() as $error)
                            {{$error}}
                            @endforeach
                            
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong class="text-success">{{ $message }}</strong>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Full Name</div>
                            <div class="col-lg-9 col-md-8">{{$user->nomGest}}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Login</div>
                            <div class="col-lg-9 col-md-8">{{$user->login}}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Job</div>
                            <div class="col-lg-9 col-md-8">
                                @if ($user->typeGest==1)
                                    Caissier
                                @elseif ($user->typeGest==2)
                                    Magasinier
                                @elseif ($user->typeGest==3)
                                    Vendeur
                                @elseif ($user->typeGest==4)
                                    Auditeur
                                @elseif ($user->typeGest==5)
                                    Financier
                                @else
                                    Administrateur
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Phone</div>
                            <div class="col-lg-9 col-md-8">{{$user->mobile}}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">status</div>
                            <div class="col-lg-9 col-md-8">
                                @if($user->actif)
                                    Actif
                                @else
                                    Inactif
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                        <!-- Profile Edit Form -->
                        <form action="{{ route('user.update', ['user'=>$user]) }}" method="POST">
                            @csrf
                            @method('PUT')


                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea class="form-control validate" rows="1" name="nomGest" id="nomGest">{{ old('nomGest', $user->nomGest) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="about" class="col-md-4 col-lg-3 col-form-label">Login</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="text" name="login" id="login" class="form-control validate" value="{{ old('login', $user->login) }}" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                <div class="col-md-8 col-lg-9">
                                    <input value="{{ old('mobile', $user->mobile) }}" name="mobile" id="mobile" type="text" class="form-control validate" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Type d'Utilisateur</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" aria-label="Default select example" name='typeGest'>
                                        <option selected value="{{ $user->typeGest }}"> 
                                            @if ($user->typeGest==1)
                                            Caissier
                                            @elseif ($user->typeGest==2)
                                            Magasinier
                                            @elseif ($user->typeGest==3)
                                            Vendeur
                                            @elseif ($user->typeGest==4)
                                            Auditeur
                                            @elseif ($user->typeGest==5)
                                            Financier
                                            @endif
                                        </option>
                                        <option value="2">Magasinier</option>
                                        <option value="1">Caissier</option>
                                        <option value="3">Vendeur</option>
                                        <option value="5">Financier</option>
                                        <option value="4">Auditeur</option>
                                    
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Status</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" aria-label="Default select example" name='actif'>
                                            
                                        <option value="1">Actif</option>
                                        <option value="0">Inactif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="password" name="password" id="new_password" class="form-control validate mb-3" oninput="validateForm()">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Confirm New Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="password" name="password_confirmation" id="new_password_confirmation" class="form-control validate mb-3" oninput="validateForm()">
                                </div>
                            </div>


                            <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form><!-- End Profile Edit Form -->

                    </div>

                    <div class="tab-pane fade pt-3" id="profile-settings">


                    </div>


                </div><!-- End Bordered Tabs -->

                </div>
            </div>

            </div>
        </div>
        </section>

    </main><!-- End #main -->

</x-layaout>
