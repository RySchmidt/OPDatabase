<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "occupationType/occupationTypeContr.inc.php";
require_once "sbs/sbsContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/occupationTypeMain.php");
	die();
}

$occupation_type_id = intval($_POST["occupation_type_id"]);
$occupation_type_name = $_POST["occupation_type_name"];

try {

	require_once "dbh.inc.php";

	$original_occupation_type = getOccupationTypeFromId($pdo, $occupation_type_id);

	// ERROR 	

	$occupation_type_errors = [];

	if ($occupation_type_id <= 0) {	
		$occupation_type_errors["empty_input"] = "Please select a occupation type to modify.";	
	}
	else {
		if (empty($occupation_type_name)) {
			$occupation_type_errors["empty_input"] = "Fill in required fields (Name).";	
		}

		if ($original_occupation_type["name"] != $occupation_type_name) {
			if (!isOccupationTypeNameUnique($pdo, $occupation_type_name)) {
				$occupation_type_errors["invalid_occupation_type_name"] = "Occupation name (" . $occupation_type_name . ") already exists within the database.";
			}
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($occupation_type_errors) {
		$_SESSION["modify_occupation_type_errors"] = $occupation_type_errors;

		$queryData = [
			"occupation_type_id" => $occupation_type_id,
			"occupation_type_name" => $original_occupation_type["name"],
		];
		$_SESSION["modify_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/occupationTypeMain.php");
		die();
	}

	modifyOccupationType($pdo, $occupation_type_id, $occupation_type_name, $occupation_type_inverse);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/occupationTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
