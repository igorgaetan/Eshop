<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>404 error</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h2>The page you are looking for doesn't exist.</h2>
        @if(auth()->user()->hasRole('caissiere'))
            <a class="btn" href={{route('facture.index')}}>Back to home</a>
        @elseif(auth()->user()->hasRole('magasinier'))
            <a class="btn" href={{route('produits.index')}}>Back to home</a>
        @elseif(auth()->user()->hasRole('gestionnaireCommande'))
            <a class="btn" href={{route('commande.index')}}>Back to home</a>
        @elseif(auth()->user()->hasRole('auditeur'))
            <a class="btn" href={{route('produits.index')}}>Back to home</a>
        @elseif(auth()->user()->hasRole('financier'))
            <a class="btn" href={{route('index')}}>Back to home</a>
        @else
            <a class="btn" href={{route('index')}}>Back to home</a>
        @endif
        <img src={{asset("images/Shrug-bro.svg")}} class="img-fluid py-5" alt="Page Not Found">
       
      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  

</body>

</html>