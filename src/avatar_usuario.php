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

		nav {
			display: flex;
			justify-content: space-evenly;
			margin-bottom: 10px;
			background-color: rgba(176, 188, 188, 0.74);
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
		}

		main {
			display: grid;
			place-content: center;
			margin-top: 10%;
		}

		form {
			display: flex;
			flex-direction: column;
			gap: 2em;
		}
	</style>
	<title>Imagen de usuario</title>
</head>
<body>
<header>
	<?php
	include './functions.php';
	checkSession();
	?>
	<h1>Imagen de usuario</h1>
	<nav>
		<h3><a href="menu.php">Volver al menú</a></h3>
		<h3><a href="logout.php">Cerrar sesión</a></h3>
	</nav>
</header>
<main>
	<picture>
		<?php
		include '../database/config.php';
		include '../database/db.php';
		$id = $_SESSION['id'];

		$cnx = db();
		$sql = "SELECT user_img FROM lotoplusdb.users WHERE user_id = '$id'";
		$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
		$row = mysqli_fetch_assoc($res);
		$img = $row['user_img'];
		mysqli_free_result($res);
		mysqli_close($cnx);
		?>
		<img src="<?php echo $img; ?>" alt="avatar" width="200" height="200">
	</picture>
	<form action="avatar_usuario.php" method="post" enctype="multipart/form-data">
		<input type="file" name="user-img">
		<input type="submit" name="submit" id="submit" value="Subir">
	</form>
	<?php
	if (isset($_POST['submit'])) {
		// IMG handler
		$copiedIMG = false;
		if (is_uploaded_file($_FILES['user-img']['tmp_name'])) {
			// Route to the folder where the images will be stored
			$imgRute = "../src/assets/img/";
			$imgName = $_FILES['user-img']['name'];
			$copiedIMG = true;

			// Detect IMG with the same name and creating a unique ID
			$existingIMG = $imgRute . $imgName;
			if (is_file($existingIMG)) {
				$imgID = time();
				$imgName = $imgID . "-" . $imgName;
			}
		}

		// If the IMG is uploaded and the IMG is not a duplicate of an existing IMG then copy the IMG to the folder
		if ($copiedIMG) {
			move_uploaded_file($_FILES['user-img']['tmp_name'], $imgRute . $imgName);
		}

		$imgRute = $imgRute . $imgName;

		// Update the IMG in the database
		$cnx = db();
		$sql = "UPDATE lotoplusdb.users SET user_img = '$imgRute' WHERE user_id = '$id'";
		$res = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
		mysqli_close($cnx);

		// Delete old IMG
		$oldIMG = $img;
		if (is_file($oldIMG)) {
			unlink($oldIMG);
		}

		// Redirect to the IMG page
		header("Location: avatar_usuario.php");
	}
	?>
</main>
</body>
</html>
