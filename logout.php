<?php
session_start();

$username = $_SESSION["username"];

setcookie("logout", $username);

session_destroy();

header("Location: index.php");
exit();
?>
