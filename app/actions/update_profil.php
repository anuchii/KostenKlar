<?php
require_once CONFIG_PATH . '/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nur POST erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . page_url('profil'));
    exit;
}

// Login prüfen
$userId = $_SESSION['user_data']['user_id'] ?? ($_SESSION['user_data']['id'] ?? null);
if ($userId === null) {
    header('Location: ' . page_url('login'));
    exit;
}

// Eingaben lesen & normalisieren
$firstName  = trim($_POST['first_name'] ?? '');
$lastName   = trim($_POST['last_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$geschlecht = trim($_POST['geschlecht'] ?? '');

// Validierung
$errors = [];
if ($firstName === '' || mb_strlen($firstName) > 100) {
    $errors[] = 'Vorname ist ungültig.';
}
if ($lastName === '' || mb_strlen($lastName) > 100) {
    $errors[] = 'Nachname ist ungültig.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'E-Mail-Adresse ist ungültig.';
}
$allowedGender = ['maennlich', 'weiblich', 'divers'];
if (!in_array($geschlecht, $allowedGender, true)) {
    $errors[] = 'Geschlecht ist ungültig.';
}

if (!empty($errors)) {
    $_SESSION['flash_error'] = implode(' ', $errors);
    header('Location: ' . page_url('profil'));
    exit;
}

// E-Mail bereits vergeben ist (außer eigene)??
$stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = :email AND user_id != :user_id');
$stmt->execute([
    ':email' => $email,
    ':user_id' => $userId,
]);
if ($stmt->fetch()) {
    $_SESSION['flash_error'] = 'Diese E-Mail-Adresse wird bereits verwendet.';
    header('Location: ' . page_url('profil'));
    exit;
}

// Update 
$stmt = $pdo->prepare('
    UPDATE users
    SET first_name = :first_name,
        last_name = :last_name,
        email = :email,
        geschlecht = :geschlecht
    WHERE user_id = :user_id
');
$stmt->execute([
    ':first_name' => $firstName,
    ':last_name'  => $lastName,
    ':email'      => $email,
    ':geschlecht' => $geschlecht,
    ':user_id'    => $userId,
]);

// Session synchronisieren
$_SESSION['user_data']['first_name'] = $firstName;
$_SESSION['user_data']['last_name']  = $lastName;
$_SESSION['user_data']['email']      = $email;
$_SESSION['user_data']['geschlecht'] = $geschlecht;

$_SESSION['flash_success'] = 'Profil erfolgreich aktualisiert.';
header('Location: ' . page_url('profil'));
exit;