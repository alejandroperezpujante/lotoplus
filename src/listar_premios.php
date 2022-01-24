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
		}

		section {
			display: grid;
			margin-top: 1em;
			place-content: center;
		}

		input {
			border: none;
			border-radius: 5px;
			padding: 0.5em;
			background-color: #696969;
			color: #ffffff;
			font-size: 1em;
			font-weight: bold;
		}

		#consultar_premios {
			background-color: whitesmoke;
			color: #282828;
			margin-top: 1em;
			transition: 0.5s ease-in-out;
			cursor: pointer;
		}

		#consultar_premios:hover {
			transition: 0.5s ease-in-out;
			background-color: #75ffb2;
		}
	</style>
	<title>Listado de premios</title>
</head>
<body>
<header>
	<h1>Listar participaciones premiadas</h1>
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
	<form action="listar_premios.php" method="post" enctype="multipart/form-data">
		<h3>Introduzca un intervalo de fechas</h3>
		<section>
			<label for="min_date">Fecha minima</label>
			<input type="date" name="min_date" id="min_date">
		</section>
		<section>
			<label for="max_date">Fecha maxima</label>
			<input type="date" name="max_date" id="max_date">
		</section>
		<input type="submit" id="consultar_premios" name="consultar_premios" value="Consultar premios">
	</form>
	<?php
	if (isset($_POST['consultar_premios'])) {
		include '../database/config.php';
		include '../database/db.php';

		$id = $_SESSION['id'];
		$min_date = $_POST['min_date'];
		$max_date = $_POST['max_date'];

		$cnx = db();
		$sql = "SELECT * FROM lotoplusdb.participations WHERE user_id = '$id' AND draw_id IN (SELECT draw_id FROM lotoplusdb.draws WHERE draw_date BETWEEN '$min_date' AND '$max_date' AND draw_id IN (SELECT draw_id from lotoplusdb.prizes WHERE prizes.number = participations.number))";
		echo "<h3>Premios obtenidos entre $min_date y $max_date</h3>";
		$res = $cnx->query($sql) or die($cnx->error);
		if ($res->num_rows > 0) {
			echo "<table>";
			echo "<tr>";
			echo "<th>Número</th>";
			echo "<th>Cantidad</th>";
			echo "<th>Snapshot</th>";
			echo "</tr>";
			while ($row = $res->fetch_assoc()) {
				$number = $row['number'];
				$amount = $row['amount'];
				$snapshot = $row['snapshot'];
				echo "<tr>";
				echo "<td>$number</td>";
				echo "<td>$amount</td>";
				echo "<td><img src='$snapshot' alt='Imagen del boleto'></td>";
				echo "</tr>";
			}
			echo "</table>";
			$res -> free_result();
			$cnx->close();
		} else {
			echo "No hay premios en ese intervalo de fechas";
		}
	}
	?>
</main>
</body>
</html>
