<?php
// Start function of all pages, check if user is logged in. If not, redirect to login page.
function checkSession() {
	session_start();
	if(isset($_SESSION['id'])) {
		echo "<h3>Bienvenido, " . $_SESSION['name'] . ".</h3>";
	} else {
		$_SESSION = array();
		session_destroy();
		header("Location: ../public/create_user.php");
	}
}

function checkSessionInitial() {
	session_start();
	if(isset($_SESSION['id'])) {
		header("Location: ../src/menu.php");
	} else {
		$_SESSION = array();
		session_destroy();
	}
}

// Get max date to allow to select in the form, and return it as a string. It can only allow 18 years old to select.
function getMaxDate() {
	$maxDate = date("Y-m-d", strtotime("-18 years"));
	return $maxDate;
}

