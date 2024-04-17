<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "relationshipType/relationshipTypeContr.inc.php";

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
		$relationship_type_errors["empty_input"] = "Please select a relationship type to delete.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["delete_data_query"]);

	if ($relationship_type_errors) {
		$_SESSION["delete_relationship_type_errors"] = $volume_errors;

		header("Location: /OPDatabase/pages/relationshipTypeMain.php");
		die();
	}

	removeRelationshipType($pdo, $relationship_type_id);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/relationshipTypeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
