<?php
    require_once __DIR__ . '/registration_validation.php';
    require_once __DIR__ . '/users.php';

    $pageName = "Register";
    $validationErrors = [];
?>

<?php
    // Handle registration POST request
    if(($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST)) {
        $userData = $_POST;
        $sucess = false;

        $validationErrors = validateRegistrationData($userData);

        if(empty($validationErrors)) {
            if(!isEmailRegistered($userData["email"], $pdo)) {
                $success = createUser($userData, $pdo);
                header("Location: login.php");
                exit();
            } else {
                $validationErrors["email"] = "Email already registered.";
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
                        <h5 class="card-title p-2">Register</h5>
                        <form method="post" action="">
                            <div class="form-group p-2">
                                <label for="first_name">First name</label>
                                <input type="text" class="form-control<?php echo(!isset($validationErrors["first_name"]) ? "" : " is-invalid"); ?>" id="first_name" name="first_name" placeholder="First name" value="<?php echo(!empty($userData["first_name"]) ? htmlspecialchars($userData["first_name"]) : ""); ?>">
                                <?php 
                                    echo(!isset($validationErrors["first_name"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["first_name"] . '</div>');
                                ?>
                            </div>
                            <div class="form-group p-2">
                                <label for="last_name">Last name</label>
                                <input type="text" class="form-control<?php echo(!isset($validationErrors["last_name"]) ? "" : " is-invalid"); ?>" id="last_name" name="last_name" placeholder="Last name" value="<?php echo(!empty($userData["last_name"]) ? htmlspecialchars($userData["last_name"]) : ""); ?>">
                                <?php 
                                    echo(!isset($validationErrors["last_name"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["last_name"] . '</div>');
                                ?>
                            </div>
                            <div class="form-group p-2">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control<?php echo(!isset($validationErrors["email"]) ? "" : " is-invalid"); ?>" id="email" name="email" placeholder="Email" value="<?php echo(!empty($userData["email"]) ? htmlspecialchars($userData["email"]) : ""); ?>">
                                <?php 
                                    echo(!isset($validationErrors["email"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["email"] . '</div>');
                                ?>
                            </div>
                            <div class="form-group p-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control<?php echo(!isset($validationErrors["password"]) ? "" : " is-invalid"); ?>" id="password" name="password" placeholder="Password" value="<?php echo(!empty($userData["password"]) ? htmlspecialchars($userData["password"]) : ""); ?>">
                                <?php 
                                    echo(!isset($validationErrors["password"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["password"] . '</div>');
                                ?>
                            </div>
                            <div class="form-group p-2">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control<?php echo(!isset($validationErrors["password_confirmation"]) ? "" : " is-invalid"); ?>" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="<?php echo(!empty($userData["password_confirmation"]) ? htmlspecialchars($userData["password_confirmation"]) : ""); ?>">
                                <?php 
                                    echo(!isset($validationErrors["password_confirmation"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["password_confirmation"] . '</div>');
                                ?>
                            </div>
                            <button type="submit" class="btn btn-primary m-2">Register</button>
                        </form>
                        <p class="card-text p-2">Have already an account? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include __DIR__ . '/footer.php'; ?>