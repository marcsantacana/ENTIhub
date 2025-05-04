<?php
session_start();

if (!isset($_SESSION["id_user"])){
    header("Location: login.php");
    exit();
}

if (!isset($_POST["message"])){
    die("Error 1: No se ha enviado el mensaje");
}

$msg = trim($_POST["message"]);

if (strlen($msg) <= 0) {
    die("Error 2: Mensaje demasiado corto");
}

if (strlen($msg) > 240) {
    die("Error 2: Mensaje demasiado largo");
}

$msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');

$id_user = intval($_SESSION["id_user"]);

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

if (!$conn) {
    die("Error 4: No se pudo conectar a la base de datos");
}

$stmt = $conn->prepare("INSERT INTO messages (message, post_time, id_user) VALUES (?, now(), ?)");
if (!$stmt) {
    die("Error 5: Query mal formada");
}

$stmt->bind_param("si", $msg, $id_user);

if (!$stmt->execute()) {
    die("Error 3: Query mal formada");
}

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>