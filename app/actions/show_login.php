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

$errors = $_SESSION['login_errors'] ?? [];
$old = $_SESSION['login_old'] ?? [];

unset($_SESSION['login_errors'], $_SESSION['login_old']);

render('login', [
    'pageTitle' => 'Login',
    'errors' => $errors,
    'old' => $old
]);
