<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
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
echo "<h1>Participation: #$participation_id</h1>";
echo "<h2>Sorteo: $row[draw_id]</h2>";
echo "<h2>Numeracion: $row[number]</h2>";
echo "<h2>Cantidad jugada: $row[amount]</h2>";
$img = $row['snapshot'];
if ($img !== '') {
	echo "<h2>Boleto:</h2>";
	echo "<img src='$row[snapshot]' alt='Imagen del boleto'>";
} else {
	echo "<h2>Boleto:</h2>";
	echo "<p>No se ha podido cargar la imagen</p>";
}
$res->free();
$cnx->close();
?>
</body>
</html>
