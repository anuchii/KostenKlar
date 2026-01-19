<?php
require_once __DIR__ . "/../config/paths.php";
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/validator.php';
require_once HELPERS_PATH . '/url.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Nur POST erlaubt
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . page_url('startseite'));
    exit;
}

$rules = [
    'first_name' => ['required', 'max:100'],
    'last_name'  => ['required', 'max:100'],
    'email'      => ['required', 'email'],
    'password'   => ['required', 'min:12'],
    'password-confirmation' => ['required', 'min:12'],
    'gebdatum'   => ['required', 'date'],
    'geschlecht' => ['required', 'in:weiblich,maennlich,divers'],
];

$messages = [
    'password.min' => 'Das Passwort muss mindestens 12 Zeichen lang sein.',
    'password-confirmation.min' => 'Das Passwort muss mindestens 12 Zeichen lang sein.',
];

[$clean, $errors] = validate($_POST, $rules, $messages);


if (empty($errors)) {
    if (($clean['password'] ?? '') !== ($clean['password-confirmation'] ?? '')) {
        $errors['password'] = 'Die Passwoerter stimmen nicht ueberein.';
        $errors['password-confirmation'] = 'Die Passwörter stimmen nicht ueberein.';
    }
}

if (empty($errors) && !empty($clean['gebdatum'])) {

    $gebdatum = new DateTime($clean['gebdatum']);
    $heute = new DateTime();
    $alter = $heute->diff($gebdatum)->y;

    if ($alter < 16) {
        $errors['gebdatum'] = 'Sie muessen mindestens 16 Jahre alt sein.';
    }
}

if (empty($errors)) {
    if (isEmailRegistered($clean['email'], $pdo)) {
        $errors['email'] = 'Diese Email ist schon registriert.';
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $old = $clean;
    unset($old['password'], $old['password-confirmation']);
    $_SESSION['old'] = $old;

    header('Location: ' . page_url('register'));
    exit;
}

$created = createUser($clean, $pdo);

if (!$created) {
    $_SESSION['errors'] = ['form' => 'Registrierung fehlgeschlagen. Bitte spaeter erneut versuchen.'];
    $old = $clean;
    unset($old['password'], $old['password-confirmation']);
    $_SESSION['old'] = $old;

    header('Location: ' . page_url('register'));
    exit;
}

$_SESSION['success'] = 'Registrierung erfolgreich! Bitte melde dich an.';
header('Location: ' . page_url('login'));
exit;
