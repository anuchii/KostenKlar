<?php
require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/validator.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/flash.php';
require_once HELPERS_PATH . '/functions.php';

require_login_or_redirect('login');
require_role_or_abort('user');

// Nur POST erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_profil();
}
// Login prüfen
$userId = $_SESSION['user_data']['user_id'] ?? ($_SESSION['user_data']['id'] ?? null);
if ($userId === null) {
    header('Location: ' . page_url('login'));
    exit;
}

$rules = [
    'first_name' => ['required', 'max:100'],
    'last_name' => ['required', 'max:100'],
    'email' => ['required', 'email', 'max:255'],
    'geschlecht' => ['required', 'in:maennlich,weiblich,divers'],
];

[$clean, $errors] = validate($_POST, $rules);

if (!empty($errors)) {
    flash_error_and_redirect(implode(' ', array_values($errors)));
}

$firstName = $clean['first_name'];
$lastName = $clean['last_name'];
$email = $clean['email'];
$geschlecht = $clean['geschlecht'];

$stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = :email AND user_id != :user_id LIMIT 1');
$stmt->execute([
    ':email' => $email,
    ':user_id' => $userId,
]);
if ($stmt->fetchColumn()) {
    flash_error_and_redirect('Diese E-Mail-Adresse wird bereits verwendet.');
}

// Update 
$clean['user_id'] = (int) $userId;
$ok = updateUserProfil($clean, $pdo);
if (!$ok) {
    flash_error_and_redirect('Profil konnte nicht aktualisiert werden.');
}

// Session synchronisieren
$_SESSION['user_data']['first_name'] = $firstName;
$_SESSION['user_data']['last_name'] = $lastName;
$_SESSION['user_data']['email'] = $email;
$_SESSION['user_data']['geschlecht'] = $geschlecht;

flash_success_and_redirect('Profil erfolgreich aktualisiert.');
