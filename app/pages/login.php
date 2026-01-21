<?php
require_once __DIR__ . '/../config/paths.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/form.php';

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!--für icons-->
  <link rel="stylesheet" href="<?= asset_url('css/auth.css') ?>">
  <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">
</head>

<body>
  <?php include_once INCLUDES_PATH . '/nav_auth.php' ?>
  <div class="container-fluid min-vh-100">
    <div class="d-flex justify-content-center align-items-start pt-5">
      <div class="card shadow border-0 auth-card">
        <div class="card-body p-4 p-md-5">
          <h1 class="h3 fw-bold mb-1">Willkommen zurück</h1>
          <p class="text-muted mb-4">Melde dich bei KostenKlar an</p>

          <form method="post" action="<?= page_url('login_action') ?>" novalidate>

            <div class="input-group mb-3">
              <span class="input-group-text bg-light text-secondary" style="width: 50px">
                <i class="bi bi-person-fill" aria-hidden="true"></i>
              </span>
              <label for="emailAddress" class="visually-hidden">E-Mail</label>
              <input
                type="email"
                id="emailAddress"
                name="email"
                class="form-control <?= field_invalid_class($validationErrors, 'email') ?>"
                placeholder="E-Mail-Adresse"
                value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                required
                autofocus
                autocomplete="email">

              <?= field_error($validationErrors, 'email') ?>
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text bg-light text-secondary icon-fixed" style="width:50px">
                <i class="bi bi-key-fill" aria-hidden="true"></i>
              </span>
              <label for="password" class="visually-hidden">Passwort</label>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Passwort"
                class="form-control <?= field_invalid_class($validationErrors, 'password') ?>"
                required
                autocomplete="current-password">
              <?= field_error($validationErrors, 'password') ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Anmelden</button>
          </form>

          <div class="text-center text-muted mt-3">
            Noch kein Account? <a href="<?= page_url('register') ?>" class="text-decoration-none">Registrierung</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include INCLUDES_PATH . '/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>

</html>