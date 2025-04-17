<?php

require_once("func.check_session.php");

$session = check_session();

if (!$session){
    header("Location: login.php");
    exit();
}

require_once("template.php");

open_html("Users");

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$query = "SELECT id_user, name FROM users;";

$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado) == 0){
    echo "Error 1: No hay usuarios";
    close_html();
    exit();
}

echo <<<EOD
<section id="users">
<body>
    <h2>Usuarios de ENTIhub</h2>
    <ul>
EOD;

while ($user = mysqli_fetch_assoc($resultado)) {
    $id_user = $user["id_user"];
    $name = htmlspecialchars($user["name"], ENT_QUOTES, 'UTF-8');
    echo "<li><a href=\"profile.php?id_user={$id_user}\">{$name}</a></li>";
}

echo <<<EOD
    </ul>
	</body>
</section>
EOD;

close_html();

?>