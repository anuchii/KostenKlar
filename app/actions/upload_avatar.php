<?php
require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/flash.php';
require_once HELPERS_PATH . '/functions.php';

/**
 * Liest die Benutzer-ID des aktuell eingeloggten Users aus der Session und gibt sie als int zurück.
 * Falls kein Benutzer eingeloggt ist, wird null zurückgegeben.
 */
function get_logged_in_user_id(): ?int
{
    $userId = $_SESSION['user_data']['user_id'] ?? ($_SESSION['user_data']['id'] ?? null);
    if ($userId === null) {
        return null;
    }
    return (int) $userId;
}

/**
 * Validiert den Avatar-Upload und gibt bei Erfolg die Dateiendung (ext) zurueck.
 * Bei Fehlern wird direkt mit Flash-Message zur Profilseite redirected.
 */
function validate_avatar_upload_or_redirect(string $tmpPath): string
{
    $maxBytes = 2 * 1024 * 1024; // 2 MB
    if ($_FILES['avatar']['size'] > $maxBytes) {
        flash_error_and_redirect('Datei zu groß. Maximal 2 MB erlaubt.');
    }

    // Ist es wirklich ein Bild?
    $imgInfo = @getimagesize($tmpPath);
    if ($imgInfo === false) {
        flash_error_and_redirect('Die Datei ist kein gültiges Bild.');
    }

    // MIME-Type serverseitig prüfen
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmpPath);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mime])) {
        flash_error_and_redirect('Nur JPG, PNG oder WebP sind erlaubt.');
    }

    return $allowed[$mime];
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_login_or_redirect('login');
require_role_or_abort('user');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_profil();
}

if (
    !isset($_FILES['avatar']) ||
    $_FILES['avatar']['error'] !== UPLOAD_ERR_OK
) {
    flash_error_and_redirect('Upload fehlgeschlagen. Bitte wähle ein Bild aus und versuche es erneut.');
}

$tmp = $_FILES['avatar']['tmp_name'];


if (!is_uploaded_file($tmp)) {
    redirect_profil();
}

// ===== Validieren =====
$ext = validate_avatar_upload_or_redirect($tmp);

/*Sicherer Dateiname*/
$userId = get_logged_in_user_id();
if ($userId === null) {
    header('Location: ' . page_url('login'));
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
    flash_error_and_redirect('Speichern des Bildes ist fehlgeschlagen. Bitte versuche es erneut.');
}
/*  Session / DB updaten */
if (!isset($pdo)) {
    flash_error_and_redirect('Datenbankverbindung fehlt.');
}

try {
    $stmt = $pdo->prepare("
        UPDATE users
        SET avatar_path = :path
        WHERE user_id = :user_id
    ");

    $stmt->execute([
        ':path' => $publicPath,
        ':user_id' => $userId,
    ]);
    $changed = $stmt->rowCount();

    if ($changed === 0) {
        flash_error_and_redirect('DB wurde nicht aktualisiert (rowCount=0). Prüfe userId/DB.');
    }

    // Session updaten, damit das neue bild angezeigt wird
    $_SESSION['user_data']['avatar_path'] = $publicPath;
    flash_success_and_redirect('Profilbild aktualisiert.');
} catch (Throwable $e) {
    flash_error_and_redirect('DB-Update fehlgeschlagen: ' . $e->getMessage());
}
