<?php
    session_start();
    require_once "pdo.php";

    if(!$_SESSION['email']){
        die("Not logged in");
    }

    if(isset($_POST['logout'])){
        header("location: view.php");
        return;
    }

    if(isset($_POST['add'])) {
        unset($_SESSION['make']);
        unset($_SESSION['year']);
        unset($_SESSION['mileage']);

        $make = htmlentities($_POST['make']);
        $year = htmlentities($_POST['year']);
        $mileage = htmlentities($_POST['mileage']);

        if(strlen($make) < 1) {
            $_SESSION['failure'] = "Make is required";
            header("location: add.php");
            return;
        } elseif (! is_numeric($year) || (! is_numeric($mileage))) {
            $_SESSION['failure'] = "Mileage and year must be numeric";
            header("location: add.php");
            return;
        } else {
            $_SESSION['make'] = $make;
            $_SESSION['year'] = $year;
            $_SESSION['mileage'] = $mileage;

            $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr,:mi)');
            $stmt->execute(array(
                ':mk'=>$make,
                ':yr'=>$year,
                ':mi'=>$mileage)
            );
            $_SESSION['success'] = "Record inserted";
            header("location: view.php");
            return;
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Zar Ni Ye (b76542c2)</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <h1>Tracking Autos for <?php echo $_SESSION['email']; ?></h1>
        <?php
            if(isset($_SESSION['failure'])) {
                echo "<p style = 'color: red;'>" . htmlentities($_SESSION['failure']) . "</p>\n";
            }
        ?>
        <form method="post">
            <p>Make:
                <input type="text" name="make" size="60">
            </p>
            <p>Year:
                <input type="text" name="year">
            </p>
            <p>Mileage:
                <input type="text" name="mileage">
            </p>
            <input type="submit" name="add" value="Add New">
            <input type="submit" name="logout" value="Cancel">
        </form>
    </div>
</body>
</html>
