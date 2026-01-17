<?php

function getLoggedUserData() {
    return $_SESSION["user_data"] ?? null;
}

function require_login() {
    $currUser = getLoggedUserData();

    if (!$currUser) {
        header('Location: ' . page_url('login'));
        exit();
    }
}

function require_admin() {
    require_login();

    $currUser = getLoggedUserData();

    if ($currUser['role'] !== 'admin') {
        http_response_code(403);
        exit('403 - Zugriff verweigert');
    }
}