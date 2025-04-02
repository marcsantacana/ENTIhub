<?php
session_start();

require_once 'template.php';

$session = false;

if (isset($_SESSION["id_user"])){
	$session = true;
}
else{
	header("Location: login.php");
	exit();
}

open_html();

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$resultado = mysqli_query($conn, $query);

if (!$resultado) {
	write_error_message("Error al buscar el nombre", 4);
	close_html();
	exit();
}

if (mysqli_num_rows($resultado) != 1){
	write_error_message("Error al buscar el nombre", 5);
	close_html();
	exit();
}

$user_data = $resultado->fetch_assoc();

// Obte ls dades de l'usuari
$user_id = $_SESSION['id_user'];
$query = "SELECT * FROM users WHERE id_user='".$user_id."'";
$query->execute([$user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Actualizar datos del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $updateQuery = $db->prepare("UPDATE users SET name = ?, username = ?, email = ?, birthdate = ?, password = ? WHERE id = ?");
    $updateQuery->execute([$name, $username, $email, $birthdate, $password, $user_id]);

    $message = "Dades actualitzades correctament.";
}

// Obte els missatges de l'usuari.
$messagesQuery = $db->prepare("SELECT * FROM messages WHERE user_id = ?");
$messagesQuery->execute([$user_id]);
$messages = $messagesQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .deleted {
            color: red;
            text-decoration: line-through;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($user['name']); ?></h1>

    <!-- Seccio per actualitzar les dades de l'usuari-->
    <section>
        <h2>Actualizar Datos</h2>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        <form method="POST">
            <label for="name">Nombre: {$user_data["name"]}  </label>
            <input type="text" id="name" name="name" required><br>

            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required><br>

            <label for="email">Email:</label> <!-- Nuevo campo -->
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required><br>

            <label for="birthdate">Fecha de Nacimiento:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user_data['birthdate']); ?>" required><br>

            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit" name="update_user">Actualizar</button>
        </form>
    </section>

    <!-- Seccio per a mostrar els missatges -->
    <section>
        <h2>Mensajes Enviados</h2>
        <ul>
            <?php foreach ($messages as $message): ?>
                <li class="<?php echo $message['is_deleted'] ? 'deleted' : ''; ?>">
                    <?php echo htmlspecialchars($message['content']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>

close_html();

