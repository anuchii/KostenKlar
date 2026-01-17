<?php

/**
 * Ermittelt den Basis-Pfad der Anwendung
 *  Bsp.: http://localhost/KostenKlar/...
 *  -> /KostenKlar/public
 * @return string Basis-URL ohne abschließenden Slash
 */
function base_url(): string{
    return BASE_URL;

}

/**
 * Erstellt interne App-Links
 * Bsp.: route('login')
 * ->index.php?page=login
 * @param string $page  Name der Seite (Dateiname ohne .php)
 * @param array $params Optionale zusätzliche URL-Parameter
 * @return string Vollständige interne URL
 */
function route(string $page, array $params = []): string
{
    $params = array_merge(['page' => $page], $params);
    return base_url() . '/index.php?' . http_build_query($params);
}
function action_url(string $action): string
{
    
    return base_url() . '/app/actions/' . ltrim($action, '/');
}

/**
 * Erstellt eine URL zu einer Seite ohne zusätzliche Parameter.
 * -> Eine Abkürzung für route().
 * @param string $page Name der Seite (Dateiname ohne .php)
 * @return string URL zur gewünschten Seite
 */

function page_url(string $page): string
{
    return route($page);
}

/**
 * Erstellt eine URL zu statischen Assets (CSS, Bilder).
 * Bsp.: asset_url('css/app.css')
 * -> /KostenKlar/public/assets/css/app.css
 * @param string $path Relativer Pfad innerhalb von /assets
 * @return string Vollständige Asset-URL
 */
function asset_url(string $path): string
{
    return base_url() . '/assets/' . ltrim($path, '/');
}

/**
 * Erstellt eine URL zu Upload-Dateien, deren Pfad relativ zu /public in der DB gespeichert ist.
 * Beispiel DB-Wert: "uploads/avatars/user_5_xxx.jpg"
 * Ergebnis: "/kostenklar/public/uploads/avatars/user_5_xxx.jpg"
 *
 * @param string|null $path Relativer Pfad (z.B. uploads/avatars/...) oder null
 * @param string|null $fallback Fallback-URL (z.B. Default-Avatar)
 * @return string Vollständige URL
 */
function upload_url(?string $path, ?string $fallback = null): string
{
    if (empty($path)) {
        return $fallback ?? '';
    }
    return base_url() . '/' . ltrim($path, '/');
}