<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
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

		form {
			display: flex;
			flex-direction: column;
			gap: 1em;
		}

		label {
			font-size: 1.2em;
			font-weight: bold;
		}
	</style>
	<title>Añadir nuevos premios</title>
</head>
<body>
<header>
	<h1>Añadir nuevos premios</h1>
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
	<form action="annadir_premios.php" method="post" enctype="multipart/form-data">
		<label for="fichero_sorteo">Suba un fichero XML con la informacion de los premios</label>
		<input type="file" name="fichero_sorteo" id="fichero_sorteo">
		<input type="submit" name="subir" id="subir" value="Añadir premios">
	</form>
	<?php
	if (isset($_POST['subir'])) {
		if (isset($_POST['subir'])) {
			include '../database/config.php';
			include '../database/db.php';

			$fichero = $_FILES['fichero_sorteo']['tmp_name'];
			$xml = simplexml_load_file($fichero);

			foreach ($xml->sorteo as $sorteo) {
				$idsorteo = $sorteo['idsorteo'];
				foreach ($sorteo->premios->premio as $premio) {
					$idpremio = $premio['idpremio'];
					$numero = $premio->numero;
					$importe = $premio->importe;
					$cnx = db();
					$sql = "INSERT INTO prizes (prize_id, draw_id, number, prize) VALUES ('$idpremio', '$idsorteo', '$numero', '$importe')";
					$result = $cnx->query($sql) or die(mysqli_error($cnx));
					$cnx -> close();
				}
			}
		} else {
			echo 'No se ha podido subir el fichero';
		}
	}
	?>
</main>
</body>
</html>
