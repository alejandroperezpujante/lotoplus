<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script>
		function showParticipation(participation_id) {
			if (participation_id === "") {
				document.getElementById("participations_list_content").innerHTML = "";
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function () {
					if (this.readyState === 4 && this.status === 200) {
						document.getElementById("participations_list_content").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET", "./get_modifiable_participation.php?participation_id=" + participation_id, true);
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
			transition: 0.5s ease-in-out;
			margin-bottom: 2em;
		}

		#participations_list_content {
			padding: 1em;
			border-radius: 10px;
			background-color: #005388;
			font-size: 1.2em;
			font-weight: bold;
			box-shadow: 10px 10px 10px #000000;
		}

		#modificar_participacion {
			width: 100%;
			padding: 0.5em;
			border-radius: 5px;
			border: 1px solid #ffffff;
			color: #ffffff;
			background-color: #9d9d9d;
			font-size: 1.7em;
			font-weight: bold;
			margin-bottom: 2em;
		}

		input {
			padding: 0.2em;
			border-radius: 5px;
			border: 1px solid #ffffff;
			color: #ffffff;
			background-color: #003b60;
			font-weight: bold;
			font-size: .8em;
		}

		h3 {
			font-size: 1.2em;
			font-weight: bold;
			text-align: center;
		}
	</style>
	<title>Modificación de participaciones</title>
</head>
<body>
<header>
	<h1>Modificación de participaciones</h1>
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
	<h2>Participaciones de <?php echo $_SESSION['name']; ?></h2>
	<?php
	include '../database/config.php';
	include '../database/db.php';
	$id = $_SESSION['id'];
	$cnx = db();
	$sql = "SELECT * FROM participations WHERE user_id = $id";
	$res = $cnx->query($sql) or die($cnx->error);
	if ($res->num_rows > 0) {
		echo "<form method='post' enctype='multipart/form-data'>";
		echo "<select name='participations_list' id='participations_list' onchange='showParticipation(this.value)'>";
		echo "<option value=''>Seleccione una participación</option>";
		while ($row = $res->fetch_assoc()) {
			echo "<option value='" . $row['participation_id'] . "'>Sorteo " . $row['draw_id'] . ", participación $row[participation_id]</option>";
		}
		echo "</select>";
		echo "</form>";
		echo "<div id='participations_list_content'></div>";
	} else {
		echo '<h3>No hay participaciones</h3>';
	}
	$res->free();
	$cnx->close();

	if (isset($_POST['modificar_participacion'])) {
		$errors = array();
		// Data checks
		$number = $_POST['number'];
		$amount = $_POST['amount'];
		$file = $_FILES['file'];

		if ($number < 1 || $number > 99) {
			$errors[] = "El número de la participación debe estar entre 1 y 99";
		}

		if ($amount < 1 || $amount > 9999) {
			$errors[] = "El importe de la participación debe estar entre 1 y 9999";
		}

		if ($file['size'] > 0) {
			if ($file['type'] != "image/jpeg" && $file['type'] != "image/png") {
				$errors[] = "El archivo debe ser una imagen";
			}
		}
		if (count($errors) > 0) {
			echo "<ul>";
			foreach ($errors as $error) {
				echo "<li>" . $error . "</li>";
			}
			echo "</ul>";
		} else {

			$copiedIMG = false;
			if (is_uploaded_file($_FILES['snapshot']['tmp_name'])) {
				// Route to the folder where the images will be stored
				// And create a unique ID
				$imgRute = "./assets/participations/";
				$imgName = $_FILES['snapshot']['name'];
				$imgID = time();
				$imgName = $imgID . "-" . $imgName;
				$copiedIMG = true;

				// If the IMG is uploaded and the IMG is not a duplicate of an existing IMG then copy the IMG to the folder
				if ($copiedIMG) {
					move_uploaded_file($_FILES['snapshot']['tmp_name'], $imgRute . $imgName);
				}

				$imgRute = $imgRute . $imgName;
			}
			if (isset($imgRute)) {
				$sql = "UPDATE lotoplusdb.participations SET number = '$number', amount = '$amount', snapshot = '$imgRute' WHERE user_id = $id";
			} else {
				$sql = "UPDATE lotoplusdb.participations SET number = '$number', amount = '$amount' WHERE user_id = $id";
			}

			$cnx = db();
			$res = $cnx -> query($sql) or die(mysqli_error($cnx));
			$cnx -> close();
		}
	}
	?>
</main>
</body>
</html>
