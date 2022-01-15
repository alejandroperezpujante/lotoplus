<?php
// función conectar: se conecta a MySQL/MariaDB, selecciona la base de datos y devuelve el identificador de conexión
function db() {
	global $HOSTNAME,$USERNAME,$PASSWORD,$DATABASE;
	$idcnx = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD,$DATABASE) or die("Error de conexión con la base de datos");
	mysqli_set_charset($idcnx,"utf8");
	return $idcnx;
}
