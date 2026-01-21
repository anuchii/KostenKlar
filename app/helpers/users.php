<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';


function createUser($userData, $pdo)
{
    // Hash password
    $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);

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

function getAllUsers($pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT * FROM users
        WHERE role = 'user'"
    );

    $statement->execute();

    // Fetch database entries
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function updateUser($userData, $pdo)
{

    // Prepare SQL statement
    $statement = $pdo->prepare(
        "UPDATE users 
            SET first_name = :first_name, 
                last_name = :last_name,
                status = :status
            WHERE user_id = :user_id"
    );

    // Bind values
    $statement->bindValue(":user_id", $userData["user_id"], PDO::PARAM_INT);
    $statement->bindValue(":first_name", $userData["first_name"]);
    $statement->bindValue(":last_name", $userData["last_name"]);
    $statement->bindValue(":status", $userData["status"]);

    // Execute statement
    $success = $statement->execute();

    return $success;
}

function updateUserProfil(array $data, PDO $pdo): bool
{
    $stmt = $pdo->prepare(
        "UPDATE users
         SET first_name = :first_name,
             last_name  = :last_name,
             email      = :email,
             geschlecht = :geschlecht
         WHERE user_id = :user_id"
    );

    $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(':first_name', $data['first_name']);
    $stmt->bindValue(':last_name', $data['last_name']);
    $stmt->bindValue(':email', $data['email']);
    $stmt->bindValue(':geschlecht', $data['geschlecht']);

    return $stmt->execute();
}

function getActiveUserCount($pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT COUNT(*) FROM users
            WHERE role = 'user' AND status = 'active'"
    );

    $statement->execute();

    // Fetch database entries
    $result = $statement->fetchColumn();

    return $result;
}

function getInActiveUserCount($pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT COUNT(*) FROM users
            WHERE role = 'user' AND status = 'inactive'"
    );

    $statement->execute();

    // Fetch database entries
    $result = $statement->fetchColumn();

    return $result;
}
/**
 * Soft-delete: markiert einen User als inaktiv.
 */
function deactivateUserById(int $user_id, PDO $pdo): bool
{
    $statement = $pdo->prepare(
        "UPDATE users
         SET status = 'inactive'
         WHERE user_id = :user_id AND role = 'user'"
    );

    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    return $statement->execute();
}

/**
 * Hard-delete: löscht den Datensatz endgültig aus der DB.
 */
function deleteUserById(int $user_id, PDO $pdo): bool
{
    try {
        $pdo->beginTransaction();


        $stmtTx = $pdo->prepare(
            "DELETE FROM transactions
             WHERE user_id = :user_id"
        );
        $stmtTx->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmtTx->execute();


        $stmtUser = $pdo->prepare(
            "DELETE FROM users
             WHERE user_id = :user_id AND role = 'user'"
        );
        $stmtUser->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $ok = $stmtUser->execute();

        $pdo->commit();
        return $ok;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        return false;
    }
}
