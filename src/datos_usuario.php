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

		#change_data {
			margin-top: 20px;
		}

		.errors {
			color: red;
			display: grid;
			place-content: center;
		}

		footer {
			padding: 5px;
			font-size: 1.2em;
			font-weight: bold;
			text-align: center;
		}

		a {
			color: #008080;
			text-decoration: none;
			transition: ease-in-out .2s
		}

		a:hover {
			transition: ease-in-out .2s;
			color: #003b60;
			text-decoration: underline;
		}
	</style>
	<title>Ficha de usuario</title>
</head>
<body>
<header>
	<h1>Datos de usuario LotoPlus</h1>
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

	<?php
	include '..//database/config.php';
	include '../database/db.php';

	$id = $_SESSION['id'];

	$cnx = db();
	$sql = "SELECT * FROM users WHERE user_id = $id";
	$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
	$row = mysqli_fetch_assoc($res);

	?>
	<form action='datos_usuario.php' method='post' enctype='multipart/form-data'>
		<table>
			<tr>
				<th>Nombre</th>
				<td><input type='text' name='name' id='name' value='<?php echo $row['name'] ?>'/></td>
			</tr>
			<tr>
				<th>Apellidos</th>
				<td><input type='text' name='surname' id='surname' value='<?php echo $row['surname'] ?>'/></td>
			</tr>
			<tr>
				<th>Nombre de usuario</th>
				<td><input type='text' name='username' id='username' value='<?php echo $row['username'] ?>'/></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><input type='email' name='email' id='email' value='<?php echo $row['email'] ?>'/></td>
			</tr>
			<tr>
				<th>Número de teléfono</th>
				<td><input type='tel' name='phone' id='phone' value='<?php echo $row['phone'] ?>'/></td>
			</tr>
			<tr>
				<th>Fecha de nacimiento</th>
				<td><input type='date' name='birth_date' id='birth_date' max='' value='<?php echo $row['birth_date'] ?>'/></td>
			</tr>
			<tr>
				<th>Beneficios</th>
				<td><input type='number' name='profits' id='profits' value='<?php echo $row['profits'] ?>'/></td>
			</tr>
			<tr>
				<th>Tipo de cuenta</th>
				<td>
					<select name='account_type' id='account_type'>
						<option value='free'>Gratuita</option>
						<option value='premium'>Suscripción</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Comunicaciones comerciales</th>
				<td><input type='checkbox' name='marketing'
									 id='marketing' <?php echo ($row['marketing'] == 1) ? "checked" : "" ?>/></td>
			</tr>
		</table>
		<input type='submit' name='change_data' id='change_data' value='Cambiar datos'>
	</form>
	<?php
	mysqli_free_result($res);
	mysqli_close($cnx);

	if (isset($_POST['change_data'])) {
		$errors = [];

		if ((strlen($_POST['name']) <= 45) and (preg_match('/^[a-zA-Z ]+$/', $_POST['name'])) == 1) {
			$name = $_POST['name'];
		} else {
			array_push($errors, 'Nombre con valor incorrecto');
		}

		if ((strlen($_POST['surname']) <= 65) and (preg_match('/^[a-zA-Z -]+$/', $_POST['surname'])) == 1) {
			$surname = $_POST['surname'];
		} else {
			array_push($errors, 'Apellidos con valor incorrecto');
		}

		if ((strlen($_POST['username']) >= 3) and (strlen($_POST['username']) <= 30) and (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) == 1) {
			$username = $_POST['username'];
		} else {
			array_push($errors, 'Nombre de usuario con valor incorrecto');
		}

		if ((preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) == 1) {
			$email = $_POST['email'];
		} else {
			array_push($errors, 'Email con valor incorrecto');
		}

		if ((preg_match('/^[6|7][0-9]{8}$/', $_POST['phone'])) == 1) {
			$phone = $_POST['phone'];
		} else {
			array_push($errors, 'Telefono con valor incorrecto');
		}

		if ($_POST['birth_date']) {
			$birth = new DateTime($_POST['birth_date']);
			$agelimit = new Datetime('-18 years');
			if ($birth < $agelimit) {
				$birth_date = $_POST['birth_date'];
			} else {
				array_push($errors, 'Fecha incorrecta');
			}
		}

		if ((preg_match('/^[6|7][0-9]{8}$/', $_POST['profits'])) == 0) {
			$profits = $_POST['profits'];
		} else {
			array_push($errors, 'Beneficios con valor incorrecto');
		}

		if (!empty($errors)) {
			echo '<div class="errors">';
			echo '<ul>';
			foreach ($errors as $error) {
				echo "<li>$error</li>";
			}
			echo '</ul>';
			echo '</div>';
			exit;
		}

		$account_type = ($_POST['account_type'] == 'free') ? 0 : 1;

		if ($_POST['marketing'] == 'on') {
			$marketing = 1;
		} else {
			$marketing = 0;
		};

		$cnx = db();
		$sql = "UPDATE lotoplusdb.users SET name = '$name', surname = '$surname', username = '$username', email = '$email', phone = '$phone', birth_date = '$birth_date', profits = '$profits', account_type = '$account_type', marketing = '$marketing'";
		$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
	}
	?>
</main>
</body>
</html>
