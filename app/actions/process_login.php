<?php

require_once CONFIG_PATH . '/paths.php';
require_once HELPERS_PATH . '/login_validation.php';
require_once HELPERS_PATH . '/users.php';
require_once CONFIG_PATH . '/db_config.php';

if (!isset($pdo)) {
    $_SESSION['login_errors'] = ['account' => 'Serverfehler: Datenbankverbindung fehlt.'];
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$userData = [
    'email' => trim($request['parameters']['POST']['email']) ?? '',
    'password' => (string)($request['parameters']['POST']['password'] ?? ''),
];

$errors = validateLoginData($userData);


$_SESSION['login_old'] = ['email' => $userData['email']];

if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    header('Location: ' . BASE_URL . '/login');
    exit;
}


if (!isEmailRegistered($userData['email'], $pdo)) {
    $_SESSION['login_errors'] = ['email' => 'E-Mail-Adresse konnte nicht gefunden werden.'];
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$userIdRow = getUserIDByEmail($userData['email'], $pdo);

$userId = $userIdRow[0]['user_id'] ?? null;
if ($userId === null) {
    $_SESSION['login_errors'] = ['email' => 'E-Mail-Adresse konnte nicht gefunden werden.'];
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$userData_db = getUserDataByUserID($userId, $pdo);

if (!isset($userData_db['password']) || !password_verify($userData['password'], $userData_db['password'])) {
    $_SESSION['login_errors'] = ['password' => 'Ungültiges Passwort.'];
    header('Location: ' . BASE_URL . '/login');
    exit;
}

if (($userData_db['status'] ?? '') !== 'active') {
    $_SESSION['login_errors'] = ['account' => 'Benutzerkonto ist inaktiv.'];
    header('Location: ' . BASE_URL . '/login');
    exit;
}

session_regenerate_id(true);

unset($userData_db['password']);
$_SESSION['user_data'] = $userData_db;

unset($_SESSION['login_old'], $_SESSION['login_errors']);

$role = $userData_db['role'] ?? null;

if ($role === 'user') {
    header('Location: ' . BASE_URL . '/dashboard');
    exit;
}

if ($role === 'admin') {
    header('Location: ' . BASE_URL . '/admin/dashboard');
    exit;
}

$_SESSION['login_errors'] = ['role' => 'Rolle unbekannt.'];
header('Location: ' . BASE_URL . '/login');
exit;
