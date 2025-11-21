<?php

require_once __DIR__ . '/config/db_config.php';


function createUser($userData, $pdo)
{
    // Hash password
    $userData["password"] = password_hash($userData["password"], PASSWORD_DEFAULT);

    // Prepare SQL statement
    $statement = $pdo->prepare(
        "INSERT INTO users (first_name, last_name, email, password, gebdatum, geschlecht, role, status)
        VALUES (:first_name, :last_name, :email, :password, :gebdatum, :geschlecht, 'user', 'active')"
    );

    // Bind values
    $statement->bindValue(":first_name", $userData["first_name"]);
    $statement->bindValue(":last_name", $userData["last_name"]);
    $statement->bindValue(":email", $userData["email"]);
    $statement->bindValue(":password", $userData["password"]);
    $statement->bindValue(":gebdatum", $userData["gebdatum"]);
    $statement->bindValue(":geschlecht", $userData["geschlecht"]);

    // Execute statement
    $success = $statement->execute();

    return $success;
}

function getUserIDByEmail($email, $pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT user_id FROM users WHERE email = :email"
    );

    // Bind values
    $statement->bindValue(":email", $email);
    $statement->execute();

    // Fetch database entries
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getPasswordByUserID($user_id, $pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT password FROM users WHERE user_id = :user_id"
    );

    // Bind values
    $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $statement->execute();

    // Fetch database entries
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function getPasswordByEmail($email, $pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT password FROM users WHERE email = :email"
    );

    // Bind values
    $statement->bindValue(":email", $email);
    $statement->execute();

    // Fetch database entries
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// Checks if email address is already registered
function isEmailRegistered($email, $pdo)
{
    $user_id = getUserIDByEmail($email, $pdo);
    $count = count($user_id);

    if ($count === 0) {
        return false;
    } else {
        return true;
    }
}

function getUserDataByUserID($user_id, $pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT * FROM users WHERE user_id = :user_id"
    );

    // Bind values
    $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $statement->execute();

    // Fetch database entries
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
}
