<?php

if (!isset($_POST["username"]) || !isset($_POST["password"])){
    echo "Error 1: Formulario no enviado";
    exit();
}

/* COMPROBAMOS USERNAME */

$username = trim($_POST["username"]);

if (strlen($username) <= 2){
    echo "Error 2a: Nombre de usuario muy corto";
    exit();
}

$username = str_replace(" ", "", $username);

if (strlen($username) > 16){
    echo "Error 2b: Nombre de usuario muy largo";
    exit();
}

/* COMPROBAMOS PASSWORD */

$password = trim($_POST["password"]);

if (strlen($password) < 4){
    echo "Error 3a: Password muy corto";
    exit();
}

$password = str_replace(" ", "", $password);

if (strlen($password) > 16){
    echo "Error 3b: Password muy largo";
    exit();
}

// Hashear la contraseña
$password = md5($password);

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

if (!$conn) {
    echo "Error 4: No se pudo conectar a la base de datos";
    exit();
}

// Usar consultas preparadas para prevenir inyección SQL
$stmt = $conn->prepare("SELECT id_user FROM users WHERE username = ? AND password = ?");
if (!$stmt) {
    echo "Error 5: Fallo al preparar la consulta";
    exit();
}

$stmt->bind_param("ss", $username, $password);

if (!$stmt->execute()) {
    echo "Error 6: Fallo al ejecutar la consulta";
    exit();
}

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0){
    echo "Error 7: Usuario o password incorrecto";
    exit();
}

if ($resultado->num_rows != 1){
    echo "Error 8: Usuario o password incorrecto";
    exit();
}

$user = $resultado->fetch_assoc();

session_start();

$_SESSION["id_user"] = $user["id_user"];

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>