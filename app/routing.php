<?php

require_once APP_PATH . '/rendering.php';

function matchRoute($request, $routes) {
    $pathMatched = false;

    foreach ($routes as $route) {
        if (strtolower($request['path']) === strtolower($route['path'])) {
            $pathMatched = true;

            if (strtoupper($request['method']) === strtoupper($route['method'])) {
                return $route;
            }
        }
    }

    // Route matched, but wrong method
    if ($pathMatched) {
        http_response_code(405);
        render('error', ['message' => 'Methode nicht erlaubt']);
        exit();
    }

    // No matching route
    http_response_code(404);
    render('error', [
        'message' => 'Seite nicht gefunden',
        'pageTitle' => 'Seite nicht gefunden'
        ]);
    exit();
}

function dispatch($request, $routes) {
    $matchedRoute = matchRoute($request, $routes);
    $handler = $matchedRoute['handler'];

    loadHandler($handler, $request);
}

function redirect($path) {
    header("location: {$path}");
    exit();
}

function loadHandler($handler, $request) {
    $handlerFilePath = ACTIONS_PATH . "/{$handler}.php";

    if (file_exists($handlerFilePath)) {
        require_once $handlerFilePath;
        exit();
    } else {
        // Handler file does not exist
        http_response_code(500);
        render('error', ['message' => 'Interner Serverfehler']);
        exit();
    }
}

