<?php
    session_start();
    require_once "pdo.php";
    if(!isset($_SESSION['email'])){
        die('Not logged in');
    }

    if(isset($_POST['logout'])) {
        header("location: index.php");
        return;
    }

    $stmt = $pdo->query("SELECT make, year, mileage FROM autos ORDER BY make");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Zar Ni Ye (b76542c2)</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <h1>Tracking Autos for <?php echo htmlentities($_SESSION['email']); ?></h1>
        <?php
                if(isset($_SESSION['success'])){
                    echo "<p style = 'color: green'>" . $_SESSION['success'] . "</p>";
                    unset($_SESSION['success']);
                }
        ?>
        <h2>Automobiles</h2>
        <p>
            <?php
                foreach($rows as $row) {
                    echo "<ul><li>";
                    echo $row['year'];
                    echo " ";
                    echo $row['make'];
                    echo " ";
                    echo "/";
                    echo " ";
                    echo $row['mileage'];
                    echo "</li></ul>";
                }
            ?>
        </p>
        <p>
            <a href="add.php">Add New</a> |
            <a href="logout.php">Logout</a>
        </p>
    </div>
</body>
</html>