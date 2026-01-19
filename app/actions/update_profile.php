<?php

require_once CONFIG_PATH . '/paths.php';
require_once CONFIG_PATH . '/db_config.php';

// Login prüfen
$userId = $_SESSION['user_data']['user_id'] ?? ($_SESSION['user_data']['id'] ?? null);
if ($userId === null) {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

$firstName  = trim($request['parameters']['POST']['first_name'] ?? '');
$lastName   = trim($request['parameters']['POST']['last_name'] ?? '');
$email      = trim($request['parameters']['POST']['email'] ?? '');
$geschlecht = trim($request['parameters']['POST']['geschlecht'] ?? '');

// ==== Validierung ====
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
    header('Location: ' . BASE_URL . '/profile');
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
    header('Location: ' . BASE_URL . '/profile');
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
header('Location: ' . BASE_URL . '/profile');
exit;