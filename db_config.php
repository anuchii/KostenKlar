<?php

$dbhost = "localhost";
$dbname = "kostenklar";
$dbuser = "root";
$dbpassword = "";

try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpassword);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connection successful";
} catch (PDOException $e) {
    echo "Database connection failed: {$e->getMessage()}";
    // End script execution
    die();
}

