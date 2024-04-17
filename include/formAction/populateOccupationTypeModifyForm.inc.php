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
		$occupation_type_errors["empty_input"] = "Select a occupation type to modify";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($occupation_type_errors) {
		$_SESSION["modify_occupation_type_errors"] = $occupation_type_errors;

		header("Location: /OPDatabase/pages/occupationTypeMain.php");
		die();
	}
	
	$results = getOccupationTypeFromId($pdo, $occupation_type_id);

	$queryData = [
			"occupation_type_id" => $occupation_type_id,
			"occupation_type_name" => $results["name"],
		];

	$_SESSION["modify_query_data"] = $queryData;

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/occupationTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
