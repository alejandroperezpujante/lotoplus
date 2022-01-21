<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
include '../database/config.php';
include '../database/db.php';
$participation_id = intval($_GET['participation_id']);

$cnx = db();
$sql = "SELECT * FROM `participations` WHERE `participation_id` = '$participation_id'";
$res = $cnx->query($sql);
$row = $res->fetch_assoc();
echo "<form action='modificar_participacion.php' method='post' enctype='multipart/form-data'>";
echo "<h1>Participation: #$participation_id</h1>";
echo "<h2>Sorteo: $row[draw_id]</h2>";
echo "<h2>Numeracion: <input type='number' name='number' value='$row[number]'></h2>";
echo "<h2>Cantidad jugada: <input type='number' name='amount' value='$row[amount]'></h2>";
$img = $row['snapshot'];
if ($img !== '') {
	echo "<h2>Boleto:</h2>";
	echo "<img src='$row[snapshot]' alt='Imagen del boleto'>";
	echo "<h2>Cambiar imagen: <input type='file' id='file' accept='image/*' name='snapshot'></h2>";
} else {
	echo "<h2>Boleto:</h2>";
	echo "<p>No se ha podido cargar la imagen</p>";
	echo "<h2>Cambiar imagen: <input type='file' id='file' accept='image/*' name='snapshot'></h2>";
}
echo "<input type='submit' value='Modificar participación' name='modificar_participacion' id='modificar_participacion'>";
echo "</form>";
$res->free();
$cnx->close();
?>
</body>
</html>
