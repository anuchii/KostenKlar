<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . page_url('startseite'));
    exit;
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once CONFIG_PATH . '/paths.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/login_validation.php';
require_once HELPERS_PATH . '/users.php';
require_once CONFIG_PATH . '/db_config.php';

if (!isset($pdo)) {
    $_SESSION['login_errors'] = ['account' => 'Serverfehler: Datenbankverbindung fehlt.'];
    header('Location: ' . page_url('login'));
    exit;
}

$userData = [
    'email' => trim($_POST['email'] ?? ''),
    'password' => (string)($_POST['password'] ?? ''),
];


$validationErrors = validateLoginData($userData);


$_SESSION['login_old'] = ['email' => $userData['email']];

if (!empty($validationErrors)) {
    $_SESSION['login_errors'] = $validationErrors;
    header('Location: ' . page_url('login'));
    exit;
}


if (!isEmailRegistered($userData['email'], $pdo)) {
    $_SESSION['login_errors'] = ['email' => 'E-Mail-Adresse konnte nicht gefunden werden.'];
    header('Location: ' . page_url('login'));
    exit;
}

$userIdRow = getUserIDByEmail($userData['email'], $pdo);
$userId = $userIdRow[0]['user_id'] ?? null;
if ($userId === null) {
    $_SESSION['login_errors'] = ['email' => 'E-Mail-Adresse konnte nicht gefunden werden.'];
    header('Location: ' . page_url('login'));
    exit;
}

$userData_db = getUserDataByUserID($userId, $pdo);

if (!isset($userData_db['password']) || !password_verify($userData['password'], $userData_db['password'])) {
    $_SESSION['login_errors'] = ['password' => 'Ungültiges Passwort.'];
    header('Location: ' . page_url('login'));
    exit;
}

if (($userData_db['status'] ?? '') !== 'active') {
    $_SESSION['login_errors'] = ['account' => 'Benutzerkonto ist inaktiv.'];
    header('Location: ' . page_url('login'));
    exit;
}

session_regenerate_id(true);

unset($userData_db['password']);
$_SESSION['user_data'] = $userData_db;

unset($_SESSION['login_old'], $_SESSION['login_errors']);

$role = $userData_db['role'] ?? null;

if ($role === 'user') {
    header('Location: ' . page_url('user_dashboard'));
    exit;
}

if ($role === 'admin') {
    header('Location: ' . page_url('admin_dashboard'));
    exit;
}

$_SESSION['login_errors'] = ['role' => 'Rolle unbekannt.'];
header('Location: ' . page_url('login'));
exit;
