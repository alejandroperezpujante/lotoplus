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
			display: block;
			font-size: 1.5em;
			font-weight: bold;
			text-align: left;
		}

		input {
			border: 1px solid #ffffff;
			border-radius: 5px;
			padding: 5px;
			font-size: 1.2em;
		}


		select {
			width: 100%;
			padding: 0.5em;
			border-radius: 5px;
			border: 1px solid #003b60;
			color: #003b60;
		}

		option {
			color: #003b60;
			font-weight: bold;
		}

		#preview {
			display: grid;
			place-content: center;
			width: 100%;
			height: auto;
			border-radius: 5px;
			border: 1px solid #003b60;
			margin-top: 2em;
		}
	</style>
	<title>Nueva participación</title>
</head>
<body>
<header>
	<h1>Registro de participaciones</h1>
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
	<form action="nueva_participacion.php" method="post" enctype="multipart/form-data">
		<label for="draw-select">Seleccione un sorteo:</label>
		<select name="draw-select" id="draw-select" required>
			<?php
			include '../database/config.php';
			include '../database/db.php';

			$cnx = db();
			$sql = "SELECT * FROM lotoplusdb.draws";
			$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
			while ($row = mysqli_fetch_assoc($res)) {
				if ($row['draw_date'] < date('Y-m-d')) {
					echo "<option value='" . $row['draw_id'] . "'>Nº" . $row['draw_number'] . " " . $row['info'] . "</option>";
				} else {
					echo "<option value='" . $row['draw_id'] . "' disabled>Nº" . $row['draw_number'] . " " . $row['info'] . "</option>";
				}
			}
			mysqli_free_result($res);
			mysqli_close($cnx);
			?>
		</select>
		<label for="number">Número de la participación</label>
		<input type="number" name="number" id="number" min="1" max="99999" required>
		<label for="amount">Importe jugado</label>
		<input type="number" name="amount" id="amount" min="1" max="9999" required>
		<label for="file">Foto de la participación</label>
		<input type="file" name="file" id="file" accept="image/*" required>
		<div id="preview">
		</div>
		<input type="submit" name="submit" id="submit" value="Registrar participación">
	</form>
	<?php
	if (isset($_POST['submit'])) {
		$errors = array();
		// Data checks
		$draw_id = $_POST['draw-select'];
		$number = $_POST['number'];
		$amount = $_POST['amount'];
		$file = $_FILES['file'];

		if ($number < 1 || $number > 99999) {
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
			$id = $_SESSION['id'];

			$copiedIMG = false;
			if (is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Route to the folder where the images will be stored
				// And create a unique ID
				$imgRute = "./assets/participations/";
				$imgName = $_FILES['file']['name'];
				$imgID = time();
				$imgName = $imgID . "-" . $imgName;
				$copiedIMG = true;

				// If the IMG is uploaded and the IMG is not a duplicate of an existing IMG then copy the IMG to the folder
				if ($copiedIMG) {
					move_uploaded_file($_FILES['file']['tmp_name'], $imgRute . $imgName);
				}

				$imgRute = $imgRute . $imgName;
			}
			$cnx = db();
			$sql = "INSERT INTO lotoplusdb.participations (user_id, draw_id, number, amount, snapshot) VALUES ('$id', '$draw_id', '$number', '$amount', '$imgRute')";
			echo "<h2>Participación registrada correctamente</h2>";
			$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
			mysqli_close($cnx);
		}
	}
	?>
</main>
<script>
	document.getElementById("file").onchange = function (e) {
		let reader = new FileReader();

		reader.readAsDataURL(e.target.files[0]);

		reader.onload = function () {
			let preview = document.getElementById('preview'),
				image = document.createElement('img');

			image.src = reader.result;

			preview.innerHTML = '';
			preview.append(image);
		};
	}
</script>
</body>
</html>
