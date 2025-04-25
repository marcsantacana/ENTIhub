<?php
require_once("func.check_session.php");
$session = check_session();

if (!$session){
	header("Location: login.php");
	exit();
}

require_once("template.php");


open_html("Dashboard: Profile", "dashboard-profile");

require_once("func.dashboard_menu.php");
dashboard_menu();


echo <<<EOD
	<h2>Mensajes del usuario</h2>
EOD;

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

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
	users.id_user=messages.id_user
WHERE
	messages.status=1
ORDER BY
	messages.post_time DESC
EOD;

$resultado = mysqli_query($conn, $query);

if (!$resultado) {
	echo "<p class=\"error_msg\">Error al leer el feed de mensajes</p>";
	echo <<<EOD
</section>
EOD;
	close_html();
	exit();
}

require_once("func.write_message.php");
while ($msg = $resultado->fetch_assoc()){
	write_message($msg);
}

close_html();

?>