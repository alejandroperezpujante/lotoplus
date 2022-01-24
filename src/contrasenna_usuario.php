<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<style>
		html {
			font-family: BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
		}

		header {
			background-color: #006699;
			color: #fff;
			padding: 5px;
			font-size: 1.2em;
			font-weight: bold;
			text-align: center;
			border-radius: 10px 10px 0 0;
		}

		main {
			margin-top: 20px;
			display: grid;
			place-content: center;
		}

		nav {
			display: flex;
			justify-content: space-evenly;
			margin-bottom: 10px;
			background-color: rgba(176, 188, 188, 0.74);
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
		}

		#change_password_form {
			display: grid;
			place-content: center;
			gap: 10px;
		}

		table {
			border-collapse: separate;
			border: solid black 1px;
			border-radius: 6px;
		}

		td, th {
			border-left: solid black 1px;
			border-top: solid black 1px;
			padding: 5px;
		}

		td:first-child, th:first-child {
			border-left: none;
			border-right: none;
		}

		input {
			border-radius: 6px;
			border: solid black 1px;
			padding: 5px;
			box-shadow: 5px 5px 5px #ccc;
		}
	</style>
	<title>Cambiar contraseña</title>
</head>
<body>
<header>
	<h1>Contraseña de usuario LotoPlus</h1>
	<?php
	include './functions.php';
	checkSession();
	?>

</header>
<main>
	<nav>
		<h3><a href="menu.php">Volver al menú</a></h3>
		<h3><a href="logout.php">Cerrar sesión</a></h3>
	</nav>
	<section>
		<form action="contrasenna_usuario.php" method="post" enctype="multipart/form-data" id="change_password_form">
			<table>
				<tr>
					<th><label for="old_password">Contraseña anterior</label></th>
					<td><input type="password" name="old_password" id="old_password"></td>
				</tr>
				<tr>
					<th><label for="new_password">Nueva contraseña</label></th>
					<td><input type="password" name="new_password" id="new_password"></td>
				</tr>
				<tr>
					<th><label for="new_password_confirm">Confirmar nueva contraseña</label></th>
					<td><input type="password" name="new_password_confirm" id="new_password_confirm"></td>
				</tr>
			</table>
			<input type="submit" name="change_password" value="Cambiar contraseña">
		</form>
	</section>
	<?php
	include '../database/config.php';
	include '../database/db.php';

	if (isset($_POST['change_password'])) {
		$old_password = $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$new_password_confirm = $_POST['new_password_confirm'];

		if ($new_password != $new_password_confirm) {
			echo '<p>Las contraseñas no coinciden</p>';
		} else {
			$id = $_SESSION['id'];

			$cnx = db();
			$sql = "SELECT * from users where user_id = $id";
			$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
			$row = mysqli_fetch_assoc($res);

			if (password_verify($old_password, $row['password'])) {

				$new_password = password_hash($new_password, PASSWORD_DEFAULT);
				$sql = "UPDATE users SET password = '$new_password' WHERE user_id = $id";
				$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
				echo '<p>Contraseña cambiada correctamente</p>';
			} else {
				echo '<p>Contraseña anterior incorrecta</p>';
			}
			mysqli_close($cnx);
		}
	}
	?>
</main>

</body>
</html>
