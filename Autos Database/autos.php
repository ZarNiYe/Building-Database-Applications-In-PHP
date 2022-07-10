<?php 
    require_once "pdo.php";
    $failure = false;
    $success = false;

    if(!isset($_GET['name'])){
        die("Name parameter is misssing");
    } elseif(isset($_POST['logout']) && $_POST['logout'] == "Logout"){
        header("location: index.php");
    } elseif(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
        if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
            $failure = "Mileage and year must be number";
        } elseif (strlen($_POST['make']) < 1){
            $failure = "Make is required";
        } else  {
            $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
            $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
            );
            $success = "Record inserted";
        }
    }
    $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>






<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Zar Ni Ye (3a4298ff)</title>
</head>
<body>
    <div class="container">
        <h1>Tracking Autos for <?php $_GET['name']; ?></h1>
        <?php 
            if($failure !== false){
                echo '<p style="color: red;">' . htmlentities($failure) . '</p>';
            }
            if($success !== false){
                echo '<p style= "color: green;">' . htmlentities($success) . '</p>';            }
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
            <input type="submit" value="Add">
            <input type="submit" value="Logout" name="logout">
        </form>
        <h2>Automobiles</h2>
        <ul>
            <?php 
                foreach($rows as $row){
                    echo "<li>";
                    echo htmlentities($row['make']) . ' ' .$row['year'] . '/' . $row['mileage'];
                };
                echo "</li><br/>"
            ?>
        </ul>
    </div>
</body>
</html>
