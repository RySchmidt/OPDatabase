<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "occupationType/occupationTypeContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/occupationTypeMain.php");
	die();
}

$occupation_type_id = intval($_POST["occupation_type_id"]);

try {

	require_once "dbh.inc.php";

	// ERROR 	

	$occupation_type_errors = [];

	if ($occupation_type_id <= 0) {	
		$occupation_type_errors["empty_input"] = "Please select a occupation type to delete.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["delete_data_query"]);

	if ($occupation_type_errors) {
		$_SESSION["delete_occupation_type_errors"] = $volume_errors;

		header("Location: /OPDatabase/pages/occupationTypeMain.php");
		die();
	}

	removeOccupationType($pdo, $occupation_type_id);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/occupationTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
