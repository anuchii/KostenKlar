<?php
require_once __DIR__ . '/../config/paths.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/form.php';

$pageName = "register";
$minGebdatum = (new DateTime('-16 years'))->format('Y-m-d');
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
$erfolgsmeldung = $_SESSION['success'] ?? '';

unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <title>Registrierung</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="<?= asset_url('css/register.css') ?>" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">
</head>


<body>
    <div class="container-fluid">
        <?php include_once INCLUDES_PATH . '/nav_auth.php'; ?>
        <div class="d-flex justify-content-center align-items-start py-5 register-wrapper">
            <div class="card shadow border-0 register-card">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 fw-bold mb-1 text-center">Registrierung</h1>
                    <p class="text-muted mb-4 text-center">Bitte füllen Sie das Formular vollständig aus.</p>
                    <?php if (!empty($erfolgsmeldung)): ?>
                        <div class="alert alert-success">
                            <?php echo $erfolgsmeldung; ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?= page_url('register_action') ?>" novalidate>

                        <div class="mb-3">
                            <label class="form-label" for="first_name"> Vorname: </label>
                            <input class="form-control <?php echo field_invalid_class($errors, 'first_name'); ?>"
                                type="text" id="first_name" placeholder="Vorname" name="first_name" required
                                value="<?php echo htmlspecialchars($old['first_name'] ?? '') ?>">
                            <?php echo field_error($errors, 'first_name'); ?>

                            <label class="form-label" for="last_name"> Nachname: </label>
                            <input class="form-control <?php echo field_invalid_class($errors, 'last_name') ?>"
                                type="text" id="last_name" placeholder="Nachname" name="last_name" required
                                value="<?php echo htmlspecialchars($old['last_name'] ?? '') ?>">
                            <?php echo field_error($errors, 'last_name'); ?>

                            <label class="form-label" for="gebdatum">Geburtsdatum</label>
                            <input class="form-control <?php echo field_invalid_class($errors, 'gebdatum') ?>"
                                id="gebdatum" type="date" min="1920-01-01" max="<?php echo $minGebdatum; ?>"
                                name="gebdatum" required
                                value="<?php echo htmlspecialchars($old['gebdatum'] ?? '') ?>">
                            <?php echo field_error($errors, 'gebdatum'); ?>


                            <label class="form-label" for="email">E-Mail Adresse: </label>
                            <input class="form-control <?php echo field_invalid_class($errors, 'email') ?>"
                                type="email" id="email" placeholder="beispiel@email.com"
                                name="email" required
                                value="<?php echo htmlspecialchars($old['email'] ?? '') ?>">
                            <?php echo field_error($errors, 'email'); ?>

                            <label class="form-label" for="password">Passwort: </label>
                            <input class="form-control <?php echo field_invalid_class($errors, 'password'); ?>"
                                type="password" id="password" pattern="[a-z0-9]{12,}" name="password" required>
                            <?php echo field_error($errors, 'password'); ?>

                            <label class="form-label" for="password-confirmation">Passwort wiederholen: </label>
                            <input class="form-control <?php echo field_invalid_class($errors, 'password-confirmation'); ?>"
                                type="password" id="password-confirmation" pattern="[a-z0-9]{12,}"
                                name="password-confirmation" required>
                            <?php echo field_error($errors, 'password-confirmation'); ?>
                        </div>

                        <label class="form-label d-block mt-2">Geschlecht:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?= field_invalid_class($errors, 'geschlecht') ?>"
                                id="geschlecht_weiblich" name="geschlecht" type="radio" value="weiblich" required
                                <?php echo (($old['geschlecht'] ?? '') === 'weiblich') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="geschlecht_weiblich">Weiblich</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?= field_invalid_class($errors, 'geschlecht') ?>"
                                id="geschlecht_maennlich" name="geschlecht" type="radio" value="maennlich" required
                                <?php echo (($old['geschlecht'] ?? '') === 'maennlich') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="geschlecht_maennlich">Männlich</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?= field_invalid_class($errors, 'geschlecht') ?>"
                                id="geschlecht_divers" name="geschlecht" type="radio" value="divers" required
                                <?php echo (($old['geschlecht'] ?? '') === 'divers') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="geschlecht_divers">Divers</label>
                        </div>
                        <?= field_error($errors, 'geschlecht', 'd-block') ?>
                        <hr>
                        <button class="btn btn-primary w-100" type="submit">Registrieren</button>
                    </form>
                    <div class="text-center text-muted mt-3">
                        Schon registriert? <a href="<?= page_url('login') ?>" class="text-decoration-none">Zum Login</a>
                    </div>
                </div>
            </div>
        </div>
        <?php include INCLUDES_PATH . '/footer.php'; ?>
    </div>
</body>

</html>