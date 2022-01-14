<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Menú Principal</title>
</head>
<body>
	<h1>Menú Principal</h1>
	<?php
	session_start();
		if (isset($_SESSION['id'])) {
			echo "<p>Bienvenido, " . $_SESSION['name'] . "</p>";
		}
	?>
	<ul>
		<li><a href="index.php">Modificar datos personales</a></li>
		<li><a href="formulario.php">Gestión de participaciones</a></li>
		<li><a href="consulta.php">Gestión de premios</a></li>
		<li><a href="salir.php">Salir</a></li>
	</ul>
</body>
</html>
