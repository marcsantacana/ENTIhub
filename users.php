<?php

require_once("func.check_session.php");

$session = check_session();

if (!$session){
	header("Location: login.php");
	exit();
}

require_once("template.php");

open_html("Users");

echo <<<EOD
<section id="users">
	<h2>Usuarios de ENTIhub</h2>
	<ul>
		<li><strong>Nombre:</strong> {$user["name"]}</li>
		<li><strong>Usuario:</strong> {$user["username"]}</li>
		<li><strong>e-mail:</strong> {$user["email"]}</li>
		<li><strong>Nacimiento:</strong> {$user["birthdate"]}</li>
		<li><strong>Password:</strong> ******</li>
	</ul>
</section>
EOD;

close_html();

?>
