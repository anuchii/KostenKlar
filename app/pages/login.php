<?php include_once INCLUDES_PATH . '/head.php' ?>

<body>
  <?php include_once INCLUDES_PATH . '/nav_auth.php' ?>
  <div class="container-fluid min-vh-100">
    <div class="d-flex justify-content-center align-items-start pt-5">
      <div class="card shadow border-0" style="max-width: 420px; width: 100%;">
        <div class="card-body p-4 p-md-5">
          <h1 class="h3 fw-bold mb-1">Willkommen zurück</h1>
          <p class="text-muted mb-4">Melde dich bei KostenKlar an</p>

          <form method="post" action="<?= BASE_URL . '/login' ?>" novalidate>

            <div class="input-group mb-3">
              <span class="input-group-text bg-light text-secondary" style="width: 50px">
                <i class="fas fa-user"></i>
              </span>
              <label for="emailAddress" class="visually-hidden">E-Mail</label>
              <input
                type="email"
                id="emailAddress"
                name="email"
                class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : '' ?>"
                placeholder="E-Mail-Adresse"
                value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                required
                autofocus
                autocomplete="email">
              <?php
              echo (!isset($errors["email"]) ? "" :
                '<div class="invalid-feedback">' . $errors["email"] . '</div>');
              ?>
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text bg-light text-secondary" style="width:50px">
                <i class="fas fa-key"></i>
              </span>
              <label for="password" class="visually-hidden">Passwort</label>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Passwort"
                class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>"
                required
                autocomplete="current-password">
              <?php
              echo (!isset($errors["password"]) ? "" :
                '<div class="invalid-feedback">' . $errors["password"] . '</div>');
              ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Anmelden</button>
          </form>

          <div class="text-center text-muted mt-3">
            Noch kein Account? <a href="<?= BASE_URL . '/register' ?>" class="text-decoration-none">Registrierung</a>
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