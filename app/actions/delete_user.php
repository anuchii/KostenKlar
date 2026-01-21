<?php
require_once __DIR__ . "/../config/paths.php";
require_once CONFIG_PATH . "/db_config.php";
require_once HELPERS_PATH . "/functions.php";
require_once HELPERS_PATH . "/users.php";
require_once HELPERS_PATH . "/url.php";

require_admin();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . route("admin_dashboard"));
    exit;
}

$userId = isset($_GET["user-id"]) ? (int) $_GET["user-id"] : (int) ($_POST["user-id"] ?? 0);
if ($userId <= 0) {
    header("Location: " . route("admin_dashboard"));
    exit;
}

deleteUserById($userId, $pdo);

header("Location: " . route("admin_dashboard"));
exit;
