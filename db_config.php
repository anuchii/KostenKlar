<?php


$dbhost = "localhost";
$port = 8889;
$dbname = "KostenKlar";
$dbuser = "root";
$dbpassword = "root";

try {
    $pdo = new PDO("mysql:host={$dbhost};port={$port};dbname={$dbname}", $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: {$e->getMessage()}";
    die();
}
return $pdo;
