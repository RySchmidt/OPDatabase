<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "sbs/sbsContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/volumeMain.php");
	die();
}

$sbs_number = intval($_POST["sbs_number"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$sbs_errors = [];

	if ($sbs_number <= 0) {
		$sbs_errors["empty_input"] = "Select sbs for deletion.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["delete_sbs_data_query"]);

	if ($sbs_errors) {
		$_SESSION["delete_sbs_errors"] = $sbs_errors;

		header("Location: /OPDatabase/pages/volumeMain.php");
		die();
	}

	removeSBS($pdo, $sbs_number);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/volumeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
