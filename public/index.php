<?php
/* session_set_cookie_params([
    'path' => '/',   //Cookie gilt für die ganze App
]); */

// Load required files
require_once __DIR__ . '/../app/config/paths.php';
require_once APP_PATH . '/routing.php';

// --------- ONLY WITHOUT VIRTUAL HOST ---------
define('BASE_URL', '/kostenklar');
// --------- ONLY WITHOUT VIRTUAL HOST ---------

// Get request info
$request['path'] = strtolower(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$request['method'] = strtoUpper($_SERVER['REQUEST_METHOD']);
$request['parameters'] = [
    'GET' => $_GET,
    'POST' => $_POST
];

// Start session
session_start();

// --------- ONLY WITHOUT VIRTUAL HOST ---------
$request['path'] = str_replace(BASE_URL, '', $request['path']);
// --------- ONLY WITHOUT VIRTUAL HOST ---------

//Normalize path
$request['path'] = '/' . trim($request['path'], '/');

// echo('<pre>');
// var_dump($request);
// echo('<pre>');
// die();

// Load routes
$routes = require(CONFIG_PATH . '/routes.php');

// Dispatch
dispatch($request, $routes);



