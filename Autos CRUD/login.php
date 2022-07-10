<?php
session_start();

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = hash('md5', $salt . "php123");

$failure = false;

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "User name and password are required";
        header("location: login.php");
        return;
    } elseif (strpos($_POST['email'], "@") === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash) {
            error_log("Login success ".$_POST['email']);
            $_SESSION['name'] = $_POST['email'];
            header("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            header("Location: login.php");
            return;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once "bot.php"; ?>
    <title>Zar Ni Ye 5a1b53ff</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST" action="login.php">
        <label for="nam">User Name</label>
        <input type="text" name="email" id="nam">
        <br>
        <label for="id_1723">Password</label>
        <input type="text" name="pass" id="id_1723">
        <br>
        <input type="submit" value="Log In">
        <a href="index.php">Cancel</a>
        <p></p>
    </form>
    <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
    </p>
</div>
</body>