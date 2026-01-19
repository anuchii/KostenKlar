<?php

/**
 * Leitet den Benutzer sofort auf die Profilseite weiter und beendet das Skript.
 */
function redirect_profil(): void
{
    header('Location: ' . page_url('profil'));
    exit;
}
/**
 * Speichert eine Fehlermeldung in der Session (flash_error) und leitet anschließend zur Profilseite weiter.
 */
function flash_error_and_redirect(string $message): void
{
    $_SESSION['flash_error'] = $message;
    redirect_profil();
}
/**
 * Speichert eine Erfolgsmeldung in der Session (flash_success) und leitet anschließend zur Profilseite weiter.
 */
function flash_success_and_redirect(string $message): void
{
    $_SESSION['flash_success'] = $message;
    redirect_profil();
}
