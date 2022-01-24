<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script>
		function showUser(user_id) {
			if (user_id === "") {
				document.getElementById("user_content").innerHTML = "";
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function () {
					if (this.readyState === 4 && this.status === 200) {
						document.getElementById("user_content").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET", "./get_user.php?user_id=" + user_id, true);
				xmlhttp.send();
			}
		}
	</script>
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
			display: grid;
			place-content: center;
			margin: 5em auto auto;
			width: fit-content;
			background-color: #003b60;
			padding: 1em;
			border-radius: 10px;
			color: #ffffff;
		}

		nav {
			display: flex;
			margin-top: 1em;
			justify-content: space-around;
		}

		a {
			color: #ffffff;
			text-decoration: none;
			font-size: 1.2em;
			font-weight: bold;
			transition: 0.5s ease-in-out;
		}

		a:hover {
			transition: 0.5s ease-in-out;
			color: #75ffb2;
		}

		select {
			width: 100%;
			padding: 0.5em;
			border-radius: 5px;
			border: 1px solid #ffffff;
			color: #ffffff;
			background-color: #003b60;
			font-size: 1.2em;
			font-weight: bold;
		}
		input {
			border-radius: 5px;
			padding: .5em;
		}
	</style>
	<title>Gestión de usuarios</title>
</head>
<body>
<header>
	<h1>Listado de usuarios</h1>
	<?php
	include './functions.php';
	checkSession();
	?>
	<nav>
		<h3><a href="menu.php">Volver al menú</a></h3>
		<h3><a href="logout.php">Cerrar sesión</a></h3>
	</nav>
</header>
<main>
	<h2>Listado de usuarios</h2>
	<form>
		<?php
		include '../database/config.php';
		include '../database/db.php';
		$cnx = db();
		$sql = "SELECT * FROM lotoplusdb.users";
		$result = $cnx->query($sql) or die($cnx->error);
		if ($result->num_rows > 0) {
			echo "<select name='user_id' onchange='showUser(this.value)'>";
			echo "<option value=''>Selecciona un usuario</option>";
			while ($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['user_id'] . "'>" . $row['name'] . "</option>";
			}
			echo "</select>";
		}
		$result->free_result();
		$cnx->close();

		if (isset($_POST['modificar_datos'])) {
			$id = $_SESSION['id'];
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$birth_date = $_POST['birth_date'];
			$profits = $_POST['profits'];
			$user_img = $_POST['user_img'];

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
				$cnx = db();
				$sql = "SELECT * FROM lotoplusdb.users WHERE username = '$username'";
				$result = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
				if ((mysqli_num_rows($result) > 0) xor ($_SESSION['username'] == $username)) {
					array_push($errors, 'El usuario indicado ya existe');
					mysqli_free_result($result);
					mysqli_close($cnx);
				}
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


			$cnx = db();
			$sql = "UPDATE lotoplusdb.users SET name = '$name', surname = '$surname', username = '$username', email = '$email', phone = '$phone', birth_date = '$birth_date', profits = '$profits' WHERE user_id = $id";
			$res = $cnx -> query($sql) or die($cnx -> error);
			$cnx -> close();
			header("Refresh: 0");
		}
		?>
	</form>
	<form action="admin_modificar_usuarios.php" method="post" enctype="multipart/form-data" id="user_content"></form>
</main>
</body>
</html>
