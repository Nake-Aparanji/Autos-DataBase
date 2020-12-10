<!DOCTYPE html>
<?php require_once "pdo.php"; ?>
<?php require_once "bootstrap.php"; ?>
<?php
session_start();
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style_index.css">
<title>Autos Database</title>
</head>
<body>
<div class="container">

<h1>Welcome to Autos Data Base</h1>

<?php


if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
?>

<?php

if (isset($_SESSION["email"])) {

    echo "<pre>";
    echo "<h3>Tracking Autos for : -  </h3>"; 
    print_r($_SESSION['email']); 
    echo "</pre>";


	echo('<table border="1">'."\n");
    echo "<tr><td>";
    echo "Make";
    echo "</td><td>";
    echo "Model";
    echo "</td><td>";
    echo "Year";
    echo "</td><td>";
    echo "Mileage";
    echo "</td><td>";
    echo "Action";
    echo "</td></tr>";
	$stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
	while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    	echo "<tr><td>";
    	echo(htmlentities($row['make']));
    	echo("</td><td>");
    	echo(htmlentities($row['model']));
    	echo("</td><td>");
    	echo(htmlentities($row['year']));
    	echo("</td><td>");
    	echo(htmlentities($row['mileage']));
    	echo("</td><td>");
    	echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
    	echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    	echo("</td></tr>\n");
	}
	?> </table> <?php
	echo "<a href='add.php'>Add New Entry</a>"."</br>";
    echo "<a href='logout.php'>Logout</a>";
}

  else {
    echo "<img src='imgs/car.jpg' id='mainLogo' alt='Car pic'>";
    echo "</br>";
    echo "<h3>Alread an user - </h3>";
    echo "</br>";
	echo "<a href='login.php' style='text-align: center;'>Please log in</a>";
    echo "</br>";
    echo "<h3>Not an user - </h3>";
    echo "</br>";
    echo "<a href='register.php'>Register</a>";
 }
?>


</div>
</body>	