<?php
require_once "pdo.php";
if(isset($_POST['cancle'])){
    header("Location: index.php");
    return;
}

$salt = "XxZzy12*_";
$store_hash = hash('md5', 'XxZzy12*_php123');
$failure = false;
if(isset($_POST['who']) && ($_POST['pass'])){
    if(strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1){
        $failure = "User name and password are required";
    } else if(strpos($_POST['who'], "@") === false) {
            $failure = "Email must have an at-sign (@)";
    } else {
        $check = hash("md5", $salt . $_POST['pass']);
        if( $check == $store_hash){
            error_log("Log in success". $_POST['who']);
            header("location: autos.php?name=" . urlencode($_POST['who']));
            return;
        } else {
            $failure = "Incorrect password";
            error_log("Log in fail" . $_POST['who'] . $check);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Zar Ni Ye (3a4298ff)'s Log In Page</title>
</head>
<body>
    <div class="container">
        <h1>Please Log In</h1>

        <?php 
        if ($failure !== false) {
            echo('<p style = "color: red;">' . htmlentities($failure) . "</p>\n");
        }
        ?>

        <form method="post">
            <label for="name">User Name</label>
            <input type="text" name="who" id="nam">
            <br>
            <label for="1723">Password</label>
            <input type="text" name="pass" id="1723">
            <br>
            <input type="submit" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
            <!-- Hint: The password is the four character sound a cat
            makes (all lower case) followed by 123. -->
        </p>
    </div>
    
</body>
</html>