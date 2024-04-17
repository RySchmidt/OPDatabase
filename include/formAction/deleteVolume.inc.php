<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "volume/volumeContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/volumeMain.php");
	die();
}

$volume_number = intval($_POST["volume_number"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$volume_errors = [];

	if ($volume_number <= 0) {
		$volume_errors["empty_input"] = "Select volume for deletion.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["delete_volume_data_query"]);

	if ($volume_errors) {
		$_SESSION["delete_volume_errors"] = $volume_errors;

		header("Location: /OPDatabase/pages/volumeMain.php");
		die();
	}

	removeVolume($pdo, $volume_number);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/volumeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
