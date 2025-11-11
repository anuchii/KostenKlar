<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!--für icons-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>

<body class="p-3 mb-2 bg-primary-subtle text-primary-emphasis">
  <div class="container">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0,0,0,0.5);">
      <div class="container">
        <a class="navbar-brand text-white" href="#">
          <img class="me-2" src="images/logo_schnell.png" width="50px" alt="logo_kostenklar">
          KostenKlar</a>

        <button class="navbar-toggler" type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" 
          aria-controls="navbarSupportedContent"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-white" aria-current="page" href="#">Startseite</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link text-white" href="#">Kontakt</a>
            </li> -->
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="btn btn-outline-warning me-2 mb-2" href="register.php" style="width: 130px;">Registrierung</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-warning" href="#" style="width: 90px;">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- hintergrundbild-->
    <style>
      body {
        background-image: url('images/option1_hintergrund.jpg.avif');
        background-size: cover;
        background-position: center center;
        background-attachment: fixed;
        height: 100%;

      }
    </style>


    <div class="mx-auto rounded text-white" class="text-center"
      style="background-color: rgba(0,0, 0, 0,5); height: 370px; width:390px; margin: 60px;">

      <h3 class="px-3 pt-3 ">Einloggen</h1>
        <hr>

        <form style="max-width:480px; margin:auto;">

          <div class="input-group mb-3">
            <span class="input-group-text bg-warning boder boder-warning" style="width: 50px">
              <i class="fas fa-user"></i>
            </span>
            <label for="emailAddress" class="sr-only"> </label>
            <input type="email" id="emailAddress" class="form-control" placeholder="Email Adresse" requiered autofocus>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text bg-warning border border-warning" style="width:50px">
              <i class="fas fa-key"></i>
            </span>
            <label for="password" class="sr-only"></label>
            <input type="password" id="password" placeholder="Passwort" class="form-control">
          </div>

          <div class="form-check">
            <label class="form-check-label" for="flexCheckdefault">Angemeldet bleiben</label>
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember">
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-warning" style="width: 100px">Anmelden</button>
          </div>


        </form>
        <hr>

        <div class="text-center">
          Noch kein Account? <a href="register.php" class="text-decoration-none">Registrierung</a> <br>
          <a href="#" class="text-decoration-none">Passwort vergessen?</a>
        </div>

    </div>

  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>