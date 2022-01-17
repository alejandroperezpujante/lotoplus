<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<style>
		html {
			font-family: BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
		}

		header, footer {
			text-align: center;
		}

		form {
			display: flex;
			flex-direction: column;
			margin: auto;
			width: fit-content;
			gap: 10px;
			background-color: beige;
			padding: 10px;
			border-radius: 10px;
		}

		label {
			font-weight: bold;
			font-size: larger;
		}

		#username, #password {
			padding: 10px;
			border-radius: 10px;
			border: 1px solid #ccc;
		}

		#submit {
			margin: auto;
			width: fit-content;
			background-color: #008080;
			color: white;
			border-radius: 10px;
			border-color: transparent;
			padding: 8px;
			font-size: 15px;
			transition: ease-in-out 0.2s;
		}

		#submit:hover {
			transition: ease-in-out 0.2s;
			background-color: #003b60;
			cursor: pointer;
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

		h3 {
			color: red;
		}

		@media (prefers-color-scheme: dark) {
			body {
				background-color: #282828;
			}

			header, footer {
				color: #DBCBBD;
			}

			h3 {
				color: red;
			}

			form {
				color: #DBCBBD;
				background-color: #87431D;
			}

			#username, #password {
				background-color: #DBCBBD;
			}

			#submit {
				background-color: #C87941;
			}

			a {
				color: #be7935;
			}
		}
	</style>
	<title>Iniciar sesión</title>
</head>
<body>
<header>
	<h1>LotoPlus</h1>
	<h2>Inicio de sesión</h2>
</header>
<form action="index.php" method="post" enctype="multipart/form-data">
	<label for="username">Nombre de usuario</label>
	<input type="text" name="username" id="username">
	<label for="password">Contraseña</label>
	<input type="password" name="password" id="password">
	<img src="" alt="">
	<input type="submit" value="Iniciar sesión" id="submit">
</form>
<footer>
	<?php
	if (isset($_POST['username']) && isset($_POST['password'])) {
		session_start();

		include '../database/config.php';
		include '../database/db.php';

		$username = $_POST['username'];
		$password = $_POST['password'];

		$cnx = db();
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			if (password_verify($password, $row['password'])) {
				$_SESSION['id'] = $row['user_id'];
				$_SESSION['name'] = $row['name'];
				$_SESSION['is_admin'] = $row['db_admin'];
				header('Location: ../src/menu.php');
			}
		} else {
			echo '<h3>Usuario o contraseña incorrectos</h3>';
			session_destroy();
		}
		mysqli_free_result($result);
		mysqli_close($cnx);
	}
	?>
	<h3><a href="create_user.php">Crear cuenta LotoPlus</a></h3>
</footer>
</body>
</html>
