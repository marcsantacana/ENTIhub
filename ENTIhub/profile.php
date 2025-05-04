<?php
session_start();

require_once("template.php");

if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
}

open_html();

require_once("db_conf.php");
require_once("func.write_error_message.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

// Verificar si se ha pasado el parámetro id_user en la URL
if (isset($_GET["id_user"])) {
    $id_user = intval($_GET["id_user"]); // Sanitizar el parámetro
} else {
    // Si no se pasa id_user, usar el id_user de la sesión
    $id_user = intval($_SESSION["id_user"]);
}

// Consultar los datos del usuario
$query = "SELECT * FROM users WHERE id_user = $id_user";
$resultado = mysqli_query($conn, $query);

if (!$resultado || mysqli_num_rows($resultado) != 1) {
    write_error_message("Error: Usuario no encontrado", 4);
    close_html();
    exit();
}

$user_data = mysqli_fetch_assoc($resultado);

// Mostrar la información del usuario
echo <<<EOD
<section id="userbio-block">
    <h2>Biografía de {$user_data["name"]}</h2>
    <ul>
        <li>Nacimiento: {$user_data["birthdate"]}</li>
    </ul>
</section>
EOD;

// Consultar los mensajes del usuario
$query = <<<EOD
SELECT
    users.id_user,
    users.username,
    users.name,
    messages.id_message,
    messages.message,
    messages.post_time
FROM
    users
INNER JOIN
    messages
ON
    users.id_user = messages.id_user
WHERE
    messages.status = 1
    AND users.id_user = {$user_data["id_user"]}
ORDER BY
    messages.post_time DESC
EOD;

$resultado = mysqli_query($conn, $query);

if (!$resultado) {
    echo "<p class=\"error_msg\">Error al leer el feed de mensajes</p>";
    write_error_message("Error al leer el feed de mensajes", 6);
    close_html();
    exit();
}

require_once("func.write_message.php");

while ($msg = mysqli_fetch_assoc($resultado)) {
    write_message($msg);
}

close_html();
?>