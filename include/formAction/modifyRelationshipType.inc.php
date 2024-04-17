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
$relationship_type_name = $_POST["relationship_type_name"];
$relationship_type_inverse = intval($_POST["relationship_type_inverse"]);

try {

	require_once "dbh.inc.php";

	$original_relationship_type = getRelationshipTypeFromId($pdo, $relationship_type_id);

	// ERROR 	

	$relationship_type_errors = [];

	if ($relationship_type_id <= 0) {	
		$relationship_type_errors["empty_input"] = "Please select a relationship type to modify.";	
	}
	else {
		if (empty($relationship_type_name)) {
			$relationship_type_errors["empty_input"] = "Fill in required fields (Name).";	
		}

		if ($original_relationship_type["name"] != $relationship_type_name) {
			if (!isRelationshipTypeNameUnique($pdo, $relationship_type_name)) {
				$relationship_type_errors["invalid_relationship_type_name"] = "Relationship name (" . $relationship_type_name . ") already exists within the database.";
			}
		}

		if ($original_relationship_type["_relationship_type_inverse"] != $relationship_type_inverse) {
			if (!isRelationshipTypeInverseUnique($pdo, $relationship_type_inverse)) {	
				$results = getRelationshipTypeFromId($pdo, $relationship_type_inverse);
				$relationship_type_errors["invalid_relationship_type_inverse"] = "Relationship type (" . $results["name"] . ") already has an inverse relationship.";
			}
		}

		if ($relationship_type_id == $relationship_type_inverse) {
				$relationship_type_errors["invalid_relationship_type_inverse"] = "A relationship type cannot be it's own inverse relationship type.";
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($relationship_type_errors) {
		$_SESSION["modify_relationship_type_errors"] = $relationship_type_errors;

		$queryData = [
			"relationship_type_id" => $relationship_type_id,
			"relationship_type_name" => $original_relationship_type["name"],
			"relationship_type_inverse" => $original_relationship_type["_relationship_type_inverse"]
		];
		$_SESSION["modify_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/relationshipTypeMain.php");
		die();
	}

	modifyRelationshipType($pdo, $relationship_type_id, $relationship_type_name, $relationship_type_inverse);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/relationshipTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
