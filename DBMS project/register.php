<?php
session_start();
?>
<?php require_once "pdo.php"; ?>
<?php require_once "bootstrap.php"; ?>


<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>

<?php
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["pass"])) {

        if (strlen($_POST['username']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
            $_SESSION["error"] = 'All fields are required';
        header("Location: register.php");
        return;
        }

        if (strlen($_POST['username']) < 1 ) {
        $_SESSION["error"] = 'Username is required';
        header("Location: register.php");
        return;
    }
    if ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = '@ symbol missing in the email field';
        //header("Location: register.php?auto_id=".$_POST['auto_id']);
        header("Location: register.php");
        return;
    }
    /*if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION["error"] = 'Mileage and year must be numeric';
        header("Location: add.php");
        return;
    }*/

            $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES ( :un, :em, :pass)');
    $stmt->execute(array(
        ':un' => $_POST['username'],
        ':em' => $_POST['email'],
        ':pass' => $_POST['pass'])
    );
    $_SESSION["success"] = "You are registered";
    header("Location: index.php");
    return;
        } 

?>

<!DOCTYPE html>
<html>
<head style="background-color: #FFFF00">
	<link rel="stylesheet" type="text/css" href="style_register.css">
	<title>Register page</title>
</head>
<body>
	<div>
		<h1>Welcome to the registration page</h1>

	<form method="post">
        <p>Username:
            <input type="text" name="username" size="60"/></p>
        <p>Email:
            <input type="text" name="email" size="60"/></p>
        <p id="pass">Password:
            <input type="password" name="pass"/></p>
        <input type="submit" name="register" value="Register">
        <a href="index.php">Cancel</a>
    </form>
	</div>
</body>
</html>