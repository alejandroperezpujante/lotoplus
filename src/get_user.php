<?php
include '../database/config.php';
include '../database/db.php';
$user_id = intval($_GET['user_id']);

$cnx = db();
$sql = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
$res = $cnx->query($sql);
$row = $res->fetch_assoc();
echo "<h1>Nombre: <input type='text' name='name' id='name' value='$row[name]'></h1>";
echo "<h2>Apellidos: <input type='text' name='surname' id='surname' value='$row[surname]'></h2>";
echo "<h2>Nombre de usuario: <input type='text' name='username' id='username' value='$row[username]'></h2>";
echo "<h2>Email: <input type='email' name='email' id='email' value='$row[email]'></h2>";
echo "<h2>Telefono: <input type='tel' name='phone' id='phone' value='$row[phone]'></h2>";
echo "<h2>Fecha de nacimiento: <input type='date' name='birth_date' id='birth_date' value='$row[birth_date]'></h2>";
echo "<h2>Beneficios: <input type='number' name='profits' id='profits' value='$row[profits]'></h2>";
$img = $row['user_img'];
if ($img !== '') {
	echo "<h2>Imagen de usuario:</h2>";
	echo "<img src='$row[user_img]' alt='Imagen del boleto'>";
} else {
	echo "<h2>Imagen de usuario:</h2>";
	echo "<p>No se ha podido cargar la imagen</p>";
}
echo "<input type='submit' name='modificar_datos' id='modificar_datos' value='Modificar datos'>";
$res->free();
$cnx->close();
?>
