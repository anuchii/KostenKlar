<?php


function base_url(): string {
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    return $dir === '/' ? '' : $dir;
}


function route(string $page, array $params = []): string {
    $params = array_merge(['page' => $page], $params);
    return base_url() . '/index.php?' . http_build_query($params);
}


function page_url(string $page): string {
    return route($page);
}


function asset_url(string $path): string {
    return base_url() . '/assets/' . ltrim($path, '/');
}