<?php
require_once __DIR__ . "/../config/paths.php";
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/registration_validation.php';

$pageName = "register";
$errors = $errors ?? [];
$erfolgsmeldung = $erfolgsmeldung ?? "";
$maxGebdatum = (new DateTime('-16 years'))->format('Y-m-d');
$backgroundImageUrl = asset_url('images/option2_hintergrund.png');

?>


<?php
//Registrierungs-POST-Anfrage verarbeiten
if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST)) {
    $userData = $_POST;
    $success = false;

    $errors = validateRegistrationData($userData);

    if (empty($errors)) {
        if (!isEmailRegistered($userData["email"], $pdo)) {
            $success = createUser($userData, $pdo);
            header('Location: ' . page_url('login'));
            exit();
        } else {
            $errors["email"] = "Diese Email ist schon registriert.";
        }
    }
}
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

    <?php include_once INCLUDES_PATH . '/nav_auth.php'; ?>
    <div class="container-fluid" style="background-color: #f8fafc;">
        <div class="d-flex justify-content-center align-items-start py-5" style="min-height: calc(100vh - 72px);">

            <div class="card shadow-sm border-0" style="max-width: 520px; width: 100%;">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 fw-bold mb-1 text-center">Registrierung</h1>
                    <p class="text-muted mb-4 text-center">Bitte füllen Sie das Formular vollständig aus.</p>


                    <?php if (!empty($erfolgsmeldung)): ?>
                        <div class="alert alert-success">
                            <?php echo $erfolgsmeldung; ?>
                        </div>
                    <?php endif; ?>

                    <form class="needs-validation" method="post" novalidate> <!--action hinzufügen-->
                        <div class="mb-3">


                            <label class="form-label" for="firstname"> Vorname: </label>
                            <input class="form-control <?php echo isset($errors['first_name']) ? 'is-invalid' : '' ?>"
                                type="text" id="first_name" placeholder="Vorname" name="first_name" required
                                value="<?php echo htmlspecialchars($_POST['first_name'] ?? '') ?>">
                            <?php if (isset($errors['first_name'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['first_name']; ?>
                                </div>
                            <?php endif; ?>


                            <label class="form-label" for="last_name"> Nachname: </label>
                            <input class="form-control <?php echo isset($errors['last_name']) ? 'is-invalid' : '' ?>"
                                type="text" id="last_name" placeholder="Nachname" name="last_name" required
                                value="<?php echo htmlspecialchars($_POST['last_name'] ?? '') ?>">
                            <?php if (isset($errors['last_name'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['last_name']; ?>
                                </div>
                            <?php endif; ?>



                            <label class="form-label" for="gebdatum">Geburtsdatum</label>
                            <input class="form-control <?php echo isset($errors['gebdatum']) ? 'is-invalid' : '' ?>"
                                id="gebdatum" type="date" min="1920-01-01" max="<?php echo $maxGebdatum; ?>"
                                name="gebdatum" required
                                value="<?php echo htmlspecialchars($_POST['gebdatum'] ?? '') ?>">
                            <?php if (isset($errors['gebdatum'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['gebdatum']; ?>
                                </div>
                            <?php endif; ?>


                            <label class="form-label" for="email">E-Mail Adresse: </label>
                            <input class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : '' ?>"
                                type="email" id="email" placeholder="beispiel@email.com"
                                name="email" required
                                value="<?php echo htmlspecialchars($_POST['email'] ?? '') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['email']; ?>
                                </div>
                            <?php endif; ?>

                            <label class="form-label" for="password">Passwort: </label>
                            <input class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>" type="password" id="password" pattern="[a-z0-9]{12,}" name="password" required>

                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['password']; ?>
                                </div>
                            <?php endif; ?>

                            <label class="form-label" for="password-confirmation">Passwort wiederholen: </label>
                            <input class="form-control <?php echo isset($errors['password-confirmation']) ? 'is-invalid' : '' ?>"
                                type="password" id="password-confirmation" pattern="[a-z0-9]{12,}"
                                name="password-confirmation" required>

                            <?php if (isset($errors['password-confirmation'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['password-confirmation']; ?>
                                </div>
                            <?php endif; ?>
                            <!-- TODO:wenn man passwort sehen möchte wird nur der type gewechselt-->


                        </div>


                        <label class="form-label d-block mt-2">Geschlecht</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo isset($errors['geschlecht']) ? 'is-invalid' : '' ?>"
                                id="geschlecht_weiblich" name="geschlecht" type="radio" value="weiblich" required
                                <?php echo (($_POST['geschlecht'] ?? '') === 'weiblich') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="geschlecht_weiblich">Weiblich</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo isset($errors['geschlecht']) ? 'is-invalid' : '' ?>"
                                id="geschlecht_maennlich" name="geschlecht" type="radio" value="maennlich" required
                                <?php echo (($_POST['geschlecht'] ?? '') === 'maennlich') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="geschlecht_maennlich">Männlich</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo isset($errors['geschlecht']) ? 'is-invalid' : '' ?>"
                                id="geschlecht_divers" name="geschlecht" type="radio" value="divers" required
                                <?php echo (($_POST['geschlecht'] ?? '') === 'divers') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="geschlecht_divers">Divers</label>
                        </div>
                        <?php if (isset($errors['geschlecht'])): ?>
                            <div class="invalid-feedback d-block">
                                <?php echo $errors['geschlecht']; ?>
                            </div>
                        <?php endif; ?>
                        <hr>

                        <hr>
                        <!-- Eigene test AGB erstellen, Zurzeit werden Vorläufer AGBs verwendet🫀-->

                        <?php if (isset($errors['terms-and-conditions'])): ?>
                            <div class="invalid-feedback d-block">
                                <?php echo $errors['terms-and-conditions']; ?>
                            </div>
                        <?php endif; ?>

                        <button class="btn btn-primary w-100" type="submit">Registrieren</button>

                    </form>

                    <div class="text-center text-muted mt-3">
                        Schon registriert? <a href="<?= page_url('login') ?>" class="text-decoration-none">Zum Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <?php include INCLUDES_PATH . '/footer.php'; ?>
</body>

</html>