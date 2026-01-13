<?php
if (!defined('ROOT_PATH')) {
  require_once __DIR__ . '/../config/paths.php';
}

require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/login_validation.php';
require_once HELPERS_PATH . '/users.php';


$validationErrors = $_SESSION['login_errors'] ?? [];
$old = $_SESSION['login_old'] ?? [];

unset($_SESSION['login_errors'], $_SESSION['login_old']);



?>


<!doctype html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="<?= asset_url('css/login.css') ?>" rel="stylesheet">
  <!--für icons-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">

</head>

<body>
  <div class="container-fluid min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0,0,0,0.1);">
      <div class="container">
        <a class="navbar-brand text-white" href="#">
          <img class="me-2" src="<?= asset_url('images/logo_schnell3.png') ?>" width="50px" alt="logo_kostenklar">
          KostenKlar</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-white" aria-current="page" href="<?= page_url('startseite') ?>">
                Startseite
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link text-white" href="#">Kontakt</a>
            </li> -->
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="btn btn-outline-warning me-2 mb-2" href="<?= page_url('register') ?>"
                style="width: 130px;">Registrierung</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-warning" href="#" style="width: 90px;">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <div class="mx-auto rounded text-white" class="text-center"
      style="background-color: rgba(0,0, 0, 0,5); height: 370px; width:390px; margin: 60px;">

      <h3 class="px-3 pt-3 ">Einloggen</h3>
      <hr>

      <form method="post" action="<?= page_url('login_action') ?>" style="max-width:480px; margin:auto;">

        <div class="input-group mb-3">
          <span class="input-group-text bg-warning boder boder-warning" style="width: 50px">
            <i class="fas fa-user"></i>
          </span>
          <label for="emailAddress" class="sr-only"> </label>
          <input type="email" id="emailAddress" name="email"
            class="form-control <?php echo isset($validationErrors['email']) ? 'is-invalid' : '' ?>"
            placeholder="Email Adresse" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" requiered
            autofocus>
          <?php
          echo (!isset($validationErrors["email"]) ? "" :
            '<div class="invalid-feedback">' . $validationErrors["email"] . '</div>');
          ?>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text bg-warning border border-warning" style="width:50px">
            <i class="fas fa-key"></i>
          </span>
          <label for="password" class="sr-only"></label>
          <input type="password" id="password" name="password" placeholder="Passwort"
            class="form-control <?php echo isset($validationErrors['password']) ? 'is-invalid' : '' ?>">
          <?php
          echo (!isset($validationErrors["password"]) ? "" :
            '<div class="invalid-feedback">' . $validationErrors["password"] . '</div>');
          ?>
        </div>

        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-warning" style="width: 100px">Anmelden</button>
        </div>


      </form>
      <hr>
      <div class="text-center">
        Noch kein Account? <a href="<?= page_url('register') ?>" class="text-decoration-none">Registrierung</a> <br>

      </div>


    </div>

  </div>
  <?php include INCLUDES_PATH . '/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>

</html>