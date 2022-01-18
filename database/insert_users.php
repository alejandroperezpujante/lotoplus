<?php
 include './config.php';
 include './db.php';

 $cnx = db();
 $password = password_hash('123456789', PASSWORD_DEFAULT);
 $sql = "INSERT INTO lotoplusdb.users
(name, surname, username, password, email, phone, birth_date, profits, user_img, account_type, marketing, db_admin, verified)
VALUES('prueba', 'eslaprueba', 'laprueba', '$password', 'prueba@prueba.com', 123456789, '2020-01-01', NULL, NULL, NULL, NULL, NULL, NULL)";
 $result = $cnx->query($sql);
 if ($result) {
	 echo "Usuario insertado correctamente";
 } else {
	 echo "Error al insertar el usuario";
 }
?>
