<?php
require_once __DIR__ . "/../config/paths.php";
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/registration_validation.php';

$pageName = "register";
$errors = $errors ?? [];
$maxGebdatum = (new DateTime('-16 years'))->format('Y-m-d');

$userData = $request['parameters']['POST'];

$errors = validateRegistrationData($userData);

if (empty($errors)) {
    if (!isEmailRegistered($userData["email"], $pdo)) {
        createUser($userData, $pdo);
        header('Location: ' . BASE_URL . '/login');
        exit();
    } else {
        $errors["email"] = "Diese Email ist schon registriert.";
    }
}

$_SESSION['registration_errors'] = $errors;
$_SESSION['registration_old'] = $userData;

header('Location: ' . BASE_URL . '/register');
exit;
