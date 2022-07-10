<?php
    require_once "pdo.php";
    session_start();

    if (isset($_POST['cancel'])) {
        header("location: index.php");
        return;
    }
    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

    if (isset($_POST['email']) && isset($_POST['pass'])) {
        unset($_SESSION['email']);
        $who = htmlentities($_POST['email']);
        $pass = htmlentities($_POST['pass']);
        $_SESSION['email'] = $who;
        if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
            $_SESSION['error'] = "Email and password are required";
            header("location: login.php");
            return;
        } elseif (strpos($who, "@")) {
            $check = hash('md5', $salt.$pass);
            if ( $check == $stored_hash ) {

                try {
                throw new Exception("Login success ".$who);
                }
                catch (Exception $ex) {
                error_log($ex->getMessage());
                }

                $_SESSION["success"] = "Logged in.";
                
                // Redirect the browser to game.php
                header("Location: view.php");
                return;
            } else {

                try {
                  throw new Exception("Login fail ".$who." $check");
                }
                catch (Exception $e) {
                  error_log($e->getMessage());
                }
                
                $_SESSION["error"] = "Incorrect password.";
                header("Location: login.php");
                return;
      
            }
        } else {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header('Location: login.php');
            return; return;
            }
        }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Zar Ni Ye (b76542c2)'s Log In Page</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <h1>Please Log In</h1>
        <?php
            if (isset($_SESSION['error'])) {
                echo ('<p style = "color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
                unset($_SESSION['error']);
            }
        ?>
        <form method="post">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"><br/>
            <label for="id_1723">Password</label>
            <input type="text" id="id_1723" name="pass"><br/>
            <input type="submit" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
        <p>
            For a password hint, view source and find a password hint in the html comments.
            <!-- Hint: The account is csev@umich.edu.The password is the three character name of the
            programming language used in this class (all lower case) followed by 123. -->
        </p>
    </div>
</body>
</html>