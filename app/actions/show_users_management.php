<?php

    require_once CONFIG_PATH . '/db_config.php';
    require_once HELPERS_PATH . '/users.php';
    require_once HELPERS_PATH . '/functions.php';

    // Require login
    $userData = getLoggedUserData();

    if (!$userData) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }

    // Require user role 'admin'
    require_admin();

    // Fetch users
    $users = getAllUsers($pdo);

    render('users_management', [
        'pageTitle' => 'Benutzerverwaltung',
        'userData' => $userData,
        'users' => $users
    ]);

