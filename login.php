<?php 
    require_once __DIR__ . "/login_validation.php";
    require_once __DIR__ . "/users.php";
    $pageName = "Login";
    $validationErrors = [];
?>

<?php
// Handle registration POST request
    if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST)) {
        $userData = $_POST;
        $sucess = false;

        $validationErrors = validateLoginData($userData);

        if(empty($validationErrors)) {

            if(isEmailRegistered($userData["email"], $pdo)) {
                $userData["user_id"] = getUserIDByEmail($userData["email"], $pdo)[0]["user_id"];
                $userData_db = getUserDataByUserID($userData["user_id"], $pdo);

                if(password_verify($userData["password"], $userData_db["password"]) && $userData_db["status"] === "active") {

                    if($userData_db["status"] === "active") {
                        unset($userData_db["password"]);
                        session_start();
                        $_SESSION["user_data"] = $userData_db;

                        if($userData_db["role"] === "user") {
                            header("Location: user_dashboard.php");
                            exit();
                        } else if($userData_db["role"] === "admin") {
                            header("Location: admin_dashboard.php");
                            exit();
                        } else {
                            $validationErrors["role"] = "Role unknown.";
                        }

                    } else {
                        $validationErrors["account"] = "Account inactive.";
                    }

                } else {
                    $validationErrors["password"] = "Incorrect password.";
                }

            } else {
            $validationErrors["email"] = "Email not found. Please register.";
            }

        }

    }

?>

<?php include __DIR__ . '\header.php'; ?>
    <main>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title p-2">Login</h5>
                        <form method="post">
                            <div class="form-group p-2">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control<?php echo(isset($validationErrors["email"]) ? " is-invalid" : ""); ?>" id="email" name="email" value="<?php echo(!empty($userData["email"]) ? htmlspecialchars($userData["email"]) : ""); ?>" placeholder="Email">
                                <?php 
                                    echo(!isset($validationErrors["email"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["email"] . '</div>');
                                ?>
                            </div>
                            <div class="form-group p-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control<?php echo(isset($validationErrors["password"]) ? " is-invalid" : ""); ?>" id="password" name="password" placeholder="Password">
                                <?php 
                                    echo(!isset($validationErrors["password"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["password"] . '</div>');
                                ?>
                            </div>
                            <button type="submit" class="btn btn-primary m-2">Login</button>
                        </form>
                        <p class="card-text p-2">No account yet? <a href="register.php">Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include __DIR__ . '\footer.php'; ?>