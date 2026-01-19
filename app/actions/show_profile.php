<?php

require_once APP_PATH . '/rendering.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/functions.php';

$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

// Fetch user data
$user_id = $userData['user_id'];
$userData = getUserDataByUserID($user_id, $pdo);

var_dump($userData);
die();

$defaultProfileImage = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';

if (!empty($userData['avatar_path'])) {
    $profileImage = APP_PATH . $userData['avatar_path'] ?? $defaultProfileImage;
} else {
    $profileImage = $defaultProfileImage;
}

render('profile', [
    'pageTitle' => 'Profil',
    'userData' => $userData,
    'profileImage' => $profileImage
]);
