<?php // Do not put any HTML above this line
require_once "pdo.php";
?>
<?php
    session_start();

    if (isset($_POST["email"]) && isset($_POST["pass"])) {
        unset($_SESSION["email"]);


        
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $sql = "SELECT email, password FROM users WHERE email='$email' 
                AND password='$password'";
        $stmt = $pdo->prepare($sql);
        $stmt -> execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
    
        if (strlen($_POST['email']) < 1 ||  strlen($_POST['pass']) < 1) {
            $_SESSION["error"] = 'All fields are required';
            header("Location: login.php");
        return;
        }
        if (strpos($_POST['email'], "@") === false) {
                $_SESSION["error"] = "Email must have an at-sign (@)";
                header('Location: login.php');
                return;
            }  
        if ($_POST["pass"] == $row['password'] && $_POST['email'] == $row['email']) {
            $_SESSION["email"] = $_POST["email"];
            error_log("Login success ".$_POST['email']);
            $_SESSION["success"] = "Logged in";
            header('Location: index.php');
            return;
        } 

        else {
                $_SESSION["error"] = "Incorect password";
                //error_log("Login fail ".$_POST['email']);
                header('Location: login.php');
                return;
        }
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style_login.css">
    <?php require_once "bootstrap.php"; ?>
    <title>Login Page</title>
</head>
<body style="background-color: #FFFF00">
<div class="container">
    <h1>Please Log In</h1>
    <?php
            if (isset($_SESSION["error"])) {
                echo('<p style="color: red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
                unset($_SESSION["error"]);
            }
        ?>
    <form method="POST">
        <label>E-mail </label>
        <input type="text" name="email"><br/>
        <label>Password </label>
        <input type="password" name="pass"><br/>
        <input type="submit" value="Log In">
        <a href="index.php">Cancel</a>
    </form>
</div>
</body>