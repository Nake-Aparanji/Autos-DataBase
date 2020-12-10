    <?php
session_start();
if ( ! isset($_SESSION['email']) ) {
    //echo "<h5>hey</h5>";
    die('Not logged in');
}

require_once "pdo.php";

if (isset($_POST["make"]) && isset($_POST["year"]) && isset($_POST["mileage"]) && isset($_POST["model"])) {

        if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
            $_SESSION["error"] = 'All fields are required';
        header("Location: add.php");
        return;
        }

        if (strlen($_POST['make']) < 1 ) {
        $_SESSION["error"] = 'Make is required';
        header("Location: add.php");
        return;
    }
    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION["error"] = 'Mileage and year must be numeric';
        header("Location: add.php");
        return;
    }

            $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES ( :mk, :mo, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':mo' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
        
    );
    $_SESSION["success"] = "Record added";
    header("Location: index.php");
    return;
        } 
?>


<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Autos Page</title>
</head>
<body style="background-color: #FFFF00;">
<div class="container">
    <h1>Tracking Autos for <?php echo $_SESSION['email']; ?></h1>
    <?php
    if (isset($_SESSION["error"])) {
                echo('<p style="color: red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
                unset($_SESSION["error"]);
            }
            
    ?>

    <form method="post">
        <p>Make:
            <input type="text" name="make" size="60"/></p>
        <p>Model:
            <input type="text" name="model" size="60"/></p>
        <p>Year:
            <input type="text" name="year"/></p>
        <p>Mileage:
            <input type="text" name="mileage"/></p>
        <input type="submit" name="Add" value="Add">
        <a href="index.php">Cancel</a>
    </form>

</div>
</body>