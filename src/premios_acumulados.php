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
	</style>
	<title>Premios acumulados</title>
</head>
<body>

<header>
	<h1>Listar premios acumulados</h1>
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
	<h3>Total de premios</h3>
	<?php
	include '../database/config.php';
	include '../database/db.php';

	$id = $_SESSION['id'];

	$cnx = db();
	$sql = "select sum(par.amount*pre.prize+usr.profits) as total from prizes pre, participations par, users usr where (pre.draw_id =  par.draw_id) and (pre.number = par.number) and (par.user_id = $id) and (usr.user_id = $id);";
	$res = $cnx -> query($sql) or die($cnx -> error);
	$row = $res -> fetch_assoc();
	if ($res -> num_rows > 0) {
		echo "<p>$row[total]€</p>";
	} else {
		echo "<p>0€</p>";
	}
	$res -> free_result();
	$cnx -> close();
	?>
</main>
</body>
</html>
