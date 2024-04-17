<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "relationshipType/relationshipTypeContr.inc.php";
require_once "sbs/sbsContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/relationshipTypeMain.php");
	die();
}

$relationship_type_id = intval($_POST["relationship_type_id"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$relationship_type_errors = [];

	if ($relationship_type_id <= 0) {
		$relationship_type_errors["empty_input"] = "Select a relationship type to modify";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($relationship_type_errors) {
		$_SESSION["modify_relationship_type_errors"] = $relationship_type_errors;

		header("Location: /OPDatabase/pages/relationshipTypeMain.php");
		die();
	}
	
	$results = getRelationshipTypeFromId($pdo, $relationship_type_id);

	$queryData = [
			"relationship_type_id" => $relationship_type_id,
			"relationship_type_name" => $results["name"],
			"relationship_type_inverse" => $results["_relationship_type_inverse"]
		];

	$_SESSION["modify_query_data"] = $queryData;

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/relationshipTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
