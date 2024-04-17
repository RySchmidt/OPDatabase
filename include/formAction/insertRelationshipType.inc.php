<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "relationshipType/relationshipTypeContr.inc.php";
require_once "sbs/sbsContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/relationshipTypeMain.php");
	die();
}

$relationship_type_name = $_POST["relationship_type_name"];
$inverse_relationship_id = intval($_POST["relationship_type_inverse"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$relationship_type_errors = [];

	if (empty($relationship_type_name)) {
		$relationship_type_errors["empty_input"] = "Fill in required fields (Name).";	
	}

	if (!isRelationshipTypeNameUnique($pdo, $relationship_type_name)) {
		$relationship_type_errors["invalid_relationship_type_name"] = "Relationship name (" . $relationship_type_name . ") already exists within the database.";
	}

	if (!isRelationshipTypeInverseUnique($pdo, $inverse_relationship_id)) {	
		$results = getRelationshipTypeFromId($pdo, $inverse_relationship_id);
		$relationship_type_errors["invalid_relationship_type_inverse"] = "Relationship type (" . $results["name"] . ") already has an inverse relationship.";
	}


	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($relationship_type_errors) {
		$_SESSION["insert_relationship_type_errors"] = $relationship_type_errors;

		$queryData = [
			"relationship_type_name" => $relationship_type_name,
			"relationship_type_inverse" => $inverse_relationship_id
		];
		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/relationshipTypeMain.php");
		die();
	}

	addRelationshipType($pdo, $relationship_type_name, $inverse_relationship_id);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/relationshipTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
