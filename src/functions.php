<?php
// Start function of all pages, check if user is logged in. If not, redirect to login page.
function checkSession() {
	session_start();
	if(isset($_SESSION['id'])) {
		echo "<h3>Bienvenido, " . $_SESSION['name'] . ".</h3>";
	} else {
		session_destroy();
		header("Location: ../public/index.php");
	}
}

// Close session
// TODO: Fix the log out script
function closeSession() {
	session_destroy();
	$session_data = session_get_cookie_params();
	setcookie(session_name(),"",$session_data["path"],$session_data["domain"]);
	header("Location: ../public/index.php");
}

// Get user data from database and display it in the form to edit.
