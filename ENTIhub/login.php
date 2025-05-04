<?php

require_once("template.php");

open_html("La xarxa social d'ENTI", "login-register");

echo '<link rel="stylesheet" href="entihub.css">';
echo '<link rel="stylesheet" href="auth.css">';

echo '<main class="main-auth">';

echo <<<EOD
<form method="POST" action="login_check.php" id="login-form">
<h2>Login</h2>
<p><label for="username-login">Usuario:</label>
<input type="text" id="username-login" name="username" /></p>

<p><label for="password-login">Password:</label>
<input type="password" id="password-login" name="password" /></p>

<input type="hidden" name="csrf_token" value="GENERATED_CSRF_TOKEN" />

<p><input type="submit" value="Entrar" /></p>
</form>
EOD;

echo <<<EOD
<form method="POST" action="register_check.php" id="register-form">
<h2>Registro</h2>
<p><label for="username-register">Usuario:</label>
<input type="text" id="username-register" name="username" /></p>

<p><label for="name-register">Nombre:</label>
<input type="text" id="name-register" name="name" /></p>

<p><label for="date-register">Nacimiento:</label>
<input type="date" id="date-register" name="date" /></p>

<p><label for="email-register">e-mail:</label>
<input type="email" id="email-register" name="email" /></p>

<p><label for="password-register">Password:</label>
<input type="password" id="password-register" name="password" /></p>

<p><label for="repassword-register">Repassword:</label>
<input type="password" id="repassword-register" name="repassword" /></p>

<input type="hidden" name="csrf_token" value="GENERATED_CSRF_TOKEN" />

<p><input type="submit" value="Registrar" /></p>
</form>
EOD;

echo '</main>';

close_html();
?>