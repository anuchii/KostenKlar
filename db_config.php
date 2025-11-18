<?php

$dbhost = "localhost";
$port = 3306;
// $port = 8889;
$dbname = "kostenklar";
// $dbname = "Kostenklar";
$dbuser = "";
// $dbpassword = "root";


try {
    $pdo = new PDO("mysql:host={$dbhost};port={$port};dbname={$dbname}", $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: {$e->getMessage()}";
    die();
}
return $pdo;
