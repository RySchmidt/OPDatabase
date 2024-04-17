<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "occupationType/occupationTypeContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/occupationTypeMain.php");
	die();
}

$occupation_type_name = $_POST["occupation_type_name"];

try {

	require_once "dbh.inc.php";

	// ERROR 

	$occupation_type_errors = [];

	if (empty($occupation_type_name)) {
		$occupation_type_errors["empty_input"] = "Fill in required fields (Name).";	
	}

	if (!isOccupationTypeNameUnique($pdo, $occupation_type_name)) {
		$occupation_type_errors["invalid_occupation_type_name"] = "Occupation name (" . $occupation_type_name . ") already exists within the database.";
	}

	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($occupation_type_errors) {
		$_SESSION["insert_occupation_type_errors"] = $occupation_type_errors;

		$queryData = [
			"occupation_type_name" => $occupation_type_name,
		];
		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/occupationTypeMain.php");
		die();
	}

	addOccupationType($pdo, $occupation_type_name);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/occupationTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
