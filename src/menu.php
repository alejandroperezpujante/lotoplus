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
			display: flex;
			flex-direction: row;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			margin-top: 10px;
			padding: 10px;
			background-color: #eee;
			border-radius: 10px;
		}

		a {
			text-decoration: none;
			color: #000;
			transition: all 0.2s ease-in-out;
		}

		a:hover {
			color: #006699;
			text-shadow: 1px 1px .5px #a6a6a6;
		}

		footer {
			display: flex;
			justify-content: center;
			align-items: center;
		}
	</style>
	<title>Menú Principal</title>
</head>
<body>
<header>
	<h1>Menú Principal LotoPlus</h1>
	<?php
	include './functions.php';
	checkSession();
	?>
</header>

<main>
	<nav>
		<ul>
			<h3>Datos de usuario</h3>
			<li><a href="datos_usuario.php">Modificar datos personales</a></li>
			<li><a href="contrasenna_usuario.php">Modificar contraseña</a></li>
			<li><a href="avatar_usuario.php">Modificar imagen de usuario</a></li>
		</ul>
	</nav>
	<nav>
		<ul>
			<h3>Gestión de participaciones</h3>
			<li><a href="nueva_participacion.php">Dar de alta una participación</a></li>
			<li><a href="modificar_participacion.php">Modificar una participación</a></li>
			<li><a href="borrar_participacion.php">Dar de baja una participación</a></li>
			<li><a href="listar_participaciones.php">Listar participaciones</a></li>
		</ul>
	</nav>
	<nav>
		<ul>
			<h3>Gestión de premios</h3>
			<li><a href="listar_premios.php">Consultar mis participaciones premiadas</a></li>
			<li><a href="premios_acumulados.php">Consultar mis premios acumulados</a></li>
		</ul>
	</nav>
	<?php
	if ($_SESSION['is_admin'] == 1) {
		echo '
				<nav>
					<ul>
						<h3>Administración</h3>
						<li><a href="annadir_premios.php">Incorporación de premios</a></li>
						<li><a href="">Gestión de sorteos</a></li>
						<li><a href="admin_modificar_usuarios.php">Gestión de usuarios</a></li>
					</ul>
				</nav>';
	}
	?>
</main>
<footer>
	<h3><a href="./logout.php">Cerrar sesión</a></h3>
</footer>
</body>
</html>
