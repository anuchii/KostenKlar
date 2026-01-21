<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/validator.php';

require_admin();

//Es werden nur POST-Requests erlaubt 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . page_url('user_management'));
    exit;
}
//Ohne valide user_id, kann man den user nicht updaten
$user_id = (int)($_POST['user_id'] ?? 0);
if ($user_id <= 0) {
    header('Location: ' . page_url('user_management'));
    exit;
}

//Nur Werte holen die man auch bearbeiten kann
$input = [
    'first_name' => $_POST['first_name'] ?? null,
    'last_name'  => $_POST['last_name'] ?? null,
    'status'     => $_POST['status'] ?? null,
];

$allowedStatus = 'active,inactive';
//Validierungs-Regeln
$rules = [
    'first_name' => ['required', 'max:100'],
    'last_name'  => ['required', 'max:100'],
    'status'     => ['required', 'in:' . $allowedStatus],
];

[$clean, $errors] = validate($input, $rules);

//Fehler werden in die Session gelegt, damit edit_user.php sie anzeigen kann
if (!empty($errors)) {
    $_SESSION['edit_user_errors'] = $errors;
    $_SESSION['edit_user_old'] = [
        'first_name' => $clean['first_name'],
        'last_name'  => $clean['last_name'],
        'status'     => $clean['status'],
    ];

    header('Location: ' . page_url('edit_user') . '?user_id=' . $user_id);
    exit;
}

$userData = [
    'user_id'    => $user_id,
    'first_name' => $clean['first_name'],
    'last_name'  => $clean['last_name'],
    'status'     => $clean['status'],
];

$ok = updateUser($userData, $pdo);
if ($ok === false) {
    $_SESSION['edit_user_errors'] = ['global' => 'Speichern fehlgeschlagen. Bitte erneut versuchen.'];
    $_SESSION['edit_user_old'] = [
        'first_name' => $userData['first_name'],
        'last_name'  => $userData['last_name'],
        'status'     => $userData['status'],
    ];

    header('Location: ' . page_url('edit_user') . '?user_id=' . $user_id);
    exit;
}

header('Location: ' . page_url('user_management'));
exit;

updateUser($userData, $pdo);