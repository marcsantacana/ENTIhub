<?php
require_once("func.check_session.php");

$session = check_session();

if (!$session){
	header("Location: login.php");
	exit();
}


if (!isset($_GET["id_message"])){
	header("Location: dashboard_messages.php");
	exit();
}

/* TODO: FILTRAR MF */

$id_message = intval($_GET["id_message"]);
if ($id_message <= 0){
	header("Location: dashboard_messages.php");
	exit();
}

$query = <<<EOD
SELECT
	*
FROM
	messages
WHERE
	id_message={$id_message}
	AND id_user={$session}
EOD;

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado) == 0){
	header("Location: dashboard_messages.php");
	exit();
}

require_once("template.php");

open_html("Dashboard");

$msg = $resultado->fetch_assoc();

echo <<<EOD
<form method="POST" action="dashboard_message_update.php">
<h2>Edita el mensaje</h2>

<input type="hidden" name="id_message" value="{$id_message}" />

<p><label for="dashboard-update-message">Mensaje:</label>
<textarea id="dashboard-update-message" name="message">
{$msg["message"]}
</textarea></p>

<p><input type="submit" name="draft" value="Guarda como borrador" /></p>
<p><input type="submit" name="publish" value="Publica mensaje" /></p>
<p><input type="submit" name="cancel" value="Cancela la edición" /></p>
</form>
EOD;


close_html();



?>
