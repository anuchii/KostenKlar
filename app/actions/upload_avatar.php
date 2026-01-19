<?php
require_once CONFIG_PATH. '/paths.php';
require_once  CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';

if (
    !isset($_FILES['avatar']) ||
    $_FILES['avatar']['error'] !== UPLOAD_ERR_OK
) {
    $_SESSION['flash_error'] = 'Upload fehlgeschlagen. Bitte wähle ein Bild aus und versuche es erneut.';
    header('Location: ' . BASE_URL . '/profile');
    exit;
}

$tmp = $_FILES['avatar']['tmp_name'];


if (!is_uploaded_file($tmp)) {
    header('Location: ' . BASE_URL . '/profile');
    exit;
}




/* ===== Validieren ===== */
$maxBytes = 2 * 1024 * 1024; // 2 MB
if ($_FILES['avatar']['size'] > $maxBytes) {
    $_SESSION['flash_error'] = 'Datei zu groß. Maximal 2 MB erlaubt.';
    header('Location: ' . BASE_URL . '/profile');
    exit;
}
/*Ist es wirklich ein Bild?*/
$imgInfo = @getimagesize($tmp);
if ($imgInfo === false) {
    $_SESSION['flash_error'] = 'Die Datei ist kein gültiges Bild.';
    header('Location: ' . BASE_URL . '/profile');
    exit;
}

/* MIME-Type serverseitig prüfen */
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($tmp);

$allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
];

if (!isset($allowed[$mime])) {
    $_SESSION['flash_error'] = 'Nur JPG, PNG oder WebP sind erlaubt.';
    header('Location: ' . BASE_URL . '/profile');
    exit;
}

$ext = $allowed[$mime];

/*Sicherer Dateiname*/

$userId = $_SESSION['user_data']['user_id'] ?? ($_SESSION['user_data']['id'] ?? null);
if ($userId === null) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$random = bin2hex(random_bytes(8));
$filename = "user_{$userId}_{$random}.{$ext}";

/*Zielordner & Pfad*/
$uploadDirFs = __DIR__ . '/../../public/uploads/avatars';
if (!is_dir($uploadDirFs)) {
    mkdir($uploadDirFs, 0755, true);
}

$targetFs = $uploadDirFs . '/' . $filename;

$publicPath = 'uploads/avatars/' . $filename;

/*  move_uploaded_file(...) */
if (!move_uploaded_file($tmp, $targetFs)) {
    $_SESSION['flash_error'] = 'Speichern des Bildes ist fehlgeschlagen. Bitte versuche es erneut.';
    header('Location: ' . BASE_URL . '/login');
    exit;
}
/*  Session / DB updaten */
if (!isset($pdo)) {
    $_SESSION['flash_error'] = 'Datenbankverbindung fehlt.';
    header('Location: ' . BASE_URL . '/login');
    exit;
}


try {
    $stmt = $pdo->prepare("
        UPDATE users
        SET avatar_path = :path
        WHERE user_id = :user_id
    ");

    $stmt->execute([
        ':path' => $publicPath,
        ':user_id'   => $userId,
    ]);


    $changed = $stmt->rowCount();

    if ($changed === 0) {
        $_SESSION['flash_error'] = 'DB wurde nicht aktualisiert (rowCount=0). Prüfe userId/DB.';
        header('Location: ' . BASE_URL . '/profile');
        exit;
    }

    // Session updaten, damit das neue bild angezeigt wird
    $_SESSION['user_data']['avatar_path'] = $publicPath;
    $_SESSION['flash_success'] = 'Profilbild aktualisiert.';

    header('Location: ' . BASE_URL . '/profile');
    exit;

} catch (Throwable $e) {
    $_SESSION['flash_error'] = 'DB-Update fehlgeschlagen: ' . $e->getMessage();
    header('Location: ' . BASE_URL . '/profile');
    exit;
}