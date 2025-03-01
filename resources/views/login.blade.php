<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

   <!-- Vendor CSS Files -->
   <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
   <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
   <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
   <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
   <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
   <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

   <!-- Template Main CSS File -->
   <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

</head>

  <body>

    <main>
      <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                  <a href="index.html" class="logo d-flex align-items-center w-auto">

                    <span class="d-none d-lg-block">{{config('app.entreprise')}}</span>
                  </a>
                </div><!-- End Logo -->

                <div class="card mb-3">

                  <div class="card-body">

                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">S'authentifier</h5>
                      <p class="text-center small">Entrez votre login & mot de passe</p>
                    </div>

                    @if ($errors->any())
                      <div class="alert alert-danger mb-3">

                      @foreach ($errors->all() as $error)
                        {{$error}}
                      @endforeach

                      </div>
                    @endif

                    <form class="row g-3 needs-validation" novalidate action="{{route('login')}}" method="POST">

                      @csrf
                      <div class="col-12">
                        <label for="yourUsername" class="form-label">Login</label>
                        <div class="input-group has-validation">
                          <span class="input-group-text" id="inputGroupPrepend">L</span>
                          <input type="text" name="login" class="form-control" id="yourUsername" required>
                          <div class="invalid-feedback">Entrez votre login!</div>
                        </div>
                      </div>

                      <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        <div class="invalid-feedback">Entrez votre mot de passe!</div>
                      </div>


                      <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Se connecter</button>
                      </div>

                    </form>

                  </div>
                </div>



              </div>
            </div>
          </div>

        </section>

      </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



  </body>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>

</html>
