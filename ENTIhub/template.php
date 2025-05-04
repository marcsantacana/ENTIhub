<?php

if (isset($_SESSION['id_user'])) {
    session_regenerate_id(true);
}

function open_html ($title = "La xarxa social d'ENTI", $body_id="")
{
	$session = false;

	if (isset($_SESSION["id_user"])){
		$session = true;
	}

	
	$loginout = "";
	if ($session){
		$loginout = "<a href=\"logout.php\">Logout</a>";
	}
	else{
		$loginout = "<a href=\"login.php\">Login</a>";
	}

	if ($body_id != "")
		$body_id = " id=\"".$body_id."\"";
	
	echo <<<EOD
<!DOCTYPE html>
<html>
<head>
	<title>{$title}</title>
	<link rel="stylesheet" type="text/css" href="entihub.css"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>

<body{$body_id}>
	<header>
		<h1><a href="index.php">ENTIhub</a></h1>
		<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="profile.php">Perfil</a></li>
				<li><a href="users.php">Usuarios</a></li>
				<li><a href="dashboard.php">Dashboard</a></li>
				<li>{$loginout}</li>
			</ul>
		</nav>
	</header>
	<main>
EOD;
}

function close_html ()
{
    echo <<<EOD
    </main>
    <footer>
        <img src="ENTIhub_logo_small.png" alt="ENTIhub Logo" style="width: 100px; height: auto; display: block; margin: 0 auto;" />
        <p>Copyright © 2025 ENTIhub - Marc Santacana</p>
        <p>
            <a href="terms.php">Condiciones de uso</a>
            <a href="privacy.php">Aviso de privacidad</a> 
            <a href="health-privacy.php">Aviso de Privacidad de Datos de Salud del Consumidor</a>
        </p>
    </footer>
</body>
</html>
EOD;
}
?>