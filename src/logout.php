<?php
session_start();
$_SESSION = array();
session_destroy();
// $session_data = session_get_cookie_params();
// setcookie(session_name(),"",$session_data["path"],$session_data["domain"]);
header("Location: ../public/create_user.php");
?>
