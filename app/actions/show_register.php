<?php

require_once APP_PATH . '/rendering.php';

// if($_SESSION['user_data']) {
//     // Logged-in user cannot access login again.
//     if ($_SESSION['user_data']['role'] == 'admin') {
//         header('Location: ' . BASE_URL . '/amin/dashboard');
//         exit;
//     } else {
//         header('Location: ' . BASE_URL . '/dashboard');
//     }
//     exit;
// } 

$errors = $_SESSION['registration_errors'] ?? [];
$old = $_SESSION['registration_old'] ?? [];

unset($_SESSION['registration_errors'], $_SESSION['registration_old']);

render('register', [
    'pageTitle' => 'Registrierung',
    'errors' => $errors,
    'old' => $old
]);