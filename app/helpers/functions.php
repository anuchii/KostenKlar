<?php

function getLoggedUserData() {
    return $_SESSION["user_data"] ?? null;
}

function require_login_or_redirect ($page) {
    $currUser = getLoggedUserData();

    if (!$currUser) {
        header('Location: ' . page_url($page));
        exit();
    }
}

function require_role_or_abort($role) {
    $currUser = getLoggedUserData();

    if ($currUser == null || $currUser['role'] !== $role) {
        http_response_code(403);
        exit('403 - Zugriff verweigert');
    }
}