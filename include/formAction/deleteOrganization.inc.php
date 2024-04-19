<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "organization/organizationContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/organizationMain.php");
	die();
}

$organization_id = intval($_POST["organization_id"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$organization_errors = [];

	if ($organization_id <= 0) {
		$organization_errors["empty_input"] = "Select a organization to modify";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["delete_query_data"]);

	if ($organization_errors) {
		$_SESSION["delete_organization_errors"] = $organization_errors;

		header("Location: /OPDatabase/pages/organizationMain.php");
		die();
	}
	
	removeOrganization($pdo, $organization_id);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/organizationMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
