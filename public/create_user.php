<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"
					integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.tailwindcss.com"></script>
	<title>Document</title>
<body>
<?php
include '../src/functions.php';

if (isset($_POST['submit'])) {

	include '../database/config.php';
	include '../database/db.php';

	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$username = $_POST['username'];
	$cnx = db();
	$sql = "SELECT * FROM lotoplusdb.users WHERE username = '$username'";
	$result = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
	if (mysqli_num_rows($result) > 0) {
		echo '<div class="bg-red-500 text-white text-center p-2">El usuario ya existe</div>';
		header('Refresh: 2; url=./create_user.php');
		exit();
	}
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$birth = $_POST['birth'];
	$_POST['account-type'] == 'free' ? $account_type = 0 : $account_type = 1;
	$profits = $_POST['profits'];
	$phone = $_POST['phone'];
	$_POST['newsletter'] == 'on' ? $newsletter = 1 : $newsletter = 0;

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

	$cnx = db();
	$sql = "INSERT INTO lotoplusdb.users (name, surname, username, password, email, phone, birth_date, profits, user_img, account_type, marketing) VALUES ('$name', '$surname', '$username', '$password', '$email', '$phone', '$birth', '$profits', '$imgRute', '$account_type', '$newsletter')";
	$result = mysqli_query($cnx, $sql) or die(mysqli_error($cnx));
	mysqli_close($cnx);
	echo "<div class='grid h-screen place-content-center'>";
	echo "<div class='bg-green-500 text-white font-bold text-center p-4 rounded-lg'>";
	echo "<h1 class='text-3xl mb-10'>Usuario creado correctamente</h1>";
	echo "<a href='./index.php' class='text-xl text-red-200 hover:text-red-800'>Iniciar sesión</a>";
	echo "</div>";
	echo "</div>";
} else {
	?>
	<div class="mt-20 mx-52 p-5 shadow-2xl rounded-lg bg-yellow-200 overflow-auto">
		<h1 class="text-center text-5xl">LotoPlus</h1>
		<hr class="m-2 border border-transparent bg-black rounded-lg"/>
		<form action="create_user.php" method="post" enctype="multipart/form-data">
			<div class="grid grid-flow-col">
				<div class="p-5">
					<label for="name" class="text-lg font-bold">Nombre:</label><br/>
					<input type="text" name="name" id="name" class="
                border border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
              " required/>
					<span id="name-tip" class="absolute w-40 left-10 bg-green-400 rounded-lg p-2 shadow-xl hidden">El nombre no debe superar los 45 caracteres</span>
					<br/>
					<label for="surname" class="text-lg font-bold">Apellidos:</label><br/>
					<input type="text" name="surname" id="surname" class="
                border border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
              " required/>
					<span id="surname-tip" class="absolute w-40 left-10 bg-green-400 rounded-lg p-2 shadow-xl hidden">Los apellidos no debe superar los 65 caracteres</span>
					<br/>
					<label for="username" class="text-lg font-bold">Nombre de usuario:</label><br/>
					<input type="text" name="username" id="username" class="
                border border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
              " required/>
					<span id="username-tip" class="absolute w-40 left-10 bg-green-400 rounded-lg p-2 shadow-xl hidden">El nombre de usuario no debe superar los 30 caracteres y mínimo 3</span>
					<br/>
					<label for="password" class="text-lg font-bold">Contraseña:</label><br/>
					<img src="../src/assets/closed-eye.svg" alt="" id="password-reveal" class="w-7 absolute ml-52 mt-2">
					<input type="password" name="password" id="password" class="
                border-4 border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
                " required/>
					<br>
					<span id="password-strength" class="font-bold"></span>
					<span id="password-tip" class="absolute w-40 left-10 bg-green-400 rounded-lg p-2 shadow-xl hidden">La contraseña debe contener minúsculas, mayúsculas, números y caracteres especiales.</span>
					<br/>
					<label for="email" class="text-lg font-bold">Correo electrónico:</label><br/>
					<input type="email" name="email" id="email" class="
                border border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
              " required/>
					<span id="email-tip" class="absolute w-40 left-10 bg-green-400 rounded-lg p-2 shadow-xl hidden">El correo electrónico debe tener un formato válido</span>
				</div>
				<div class="p-5">
					<label for="birth" class="text-lg font-bold">Fecha de nacimiento:</label><br/>
					<input type="date" name="birth" id="birth" max="<?php echo getMaxDate(); ?>" class="
                border border-transparent
                focus:outline-none focus:border-transparent
                rounded-lg
                p-2
                mb-2
              " required/>
					<span id="birth-tip" class="absolute w-40 ml-14 bg-green-400 rounded-lg p-2 shadow-xl hidden">Se deben tener al menos 18 años</span>
					<br/>
					<label for="user-img" class="text-lg font-bold">Imagen de usuario:</label><br/>
					<input type="file" name="user-img" id="user-img" accept="image/png, image/jpeg, image/gif" size="1024"/>
					<br/>
					<br/>
					<label for="account-type" class="text-lg font-bold">Tipo de cuenta:</label><br/>
					<select name="account-type" id="account-type" class="
                border border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
              " required>
						<option value="free">Gratis</option>
						<option value="paid">Suscripción</option>
					</select>
					<br/>
					<label for="profits" class="text-lg font-bold">Ganancias iniciales:</label><br/>
					<input type="number" name="profits" id="profits" step=".01" class="
                border border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
              "/>
					<span id="profits-tip" class="absolute w-40 ml-10 bg-green-400 rounded-lg p-2 shadow-xl hidden">Los beneficios pueden ser nulos, cero, positivos o negativos</span>
					<br/>
					<label for="phone" class="text-lg font-bold">Número de telefono:</label><br/>
					<input type="text" name="phone" id="phone" minlength="9" maxlength="9" class="
                border border-transparent
                focus:outline-none
                focus:border-transparent
                rounded-lg
                p-2
                mb-2
              " required/>
					<span id="phone-tip" class="absolute w-40 ml-10 bg-green-400 rounded-lg p-2 shadow-xl hidden">Debe ser un número de telefono movil válido en España</span>
				</div>
			</div>
			<div>
				<div>
					<input type="checkbox" name="conditions" id="conditions" class="transform scale-150 m-2" required/>
					<label for="conditions" class="text-lg font-bold">Acepto las Condiciones de uso de LotoPlus</label>
					<br/>
					<input type="checkbox" name="newsletter" id="newsletter" class="transform scale-150 m-2"/>
					<label for="newsletter" class="text-sm font-light">
						Me gustaría recibir novedades de marketing de LotoPlus por correo
						electrónico</label>
				</div>
				<div>
					<button type="submit" id="submit" name="submit" class="
                p-2
                m-2
                rounded-lg
                text-white text-xl
                font-bold
                bg-gray-500
              " disabled>CREAR CUENTA
					</button>
					<button type="reset" id="reset" name="reset"
									class="p-2 m-2 rounded-lg text-white text-xl font-bold bg-red-500 hover:bg-red-800">CANCELAR
					</button>
					<a href="index.php" class="text-indigo-500 m-5 p-2 font-bold bg-gray-300 rounded-lg">Iniciar
						sesión</a>
				</div>
			</div>
		</form>
	</div>
	<?php
}
?>
<script src="main.js"></script>
</body>
</html>
