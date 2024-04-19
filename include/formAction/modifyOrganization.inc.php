<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "organization/organizationContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/organizationMain.php");
	die();
}


$organization_id = intval($_POST["organization_id"]);
$organization_name = $_POST["organization_name"];
$info_cache_id = intval($_POST["info_cache_id"]);

try {

	require_once "dbh.inc.php";

	$results = getOrganizationFromId($pdo, $organization_id);

	// ERROR 

	$organization_errors = [];

	if ($organization_id <= 0) {
		$organization_errors["no_selection"] = "Select a organization for modification.";	
	}
	else {
		if ($info_cache_id <= 0
			|| empty($organization_name)) {
			$organization_errors["empty_input"] = "Required fields (Name, Introduced In) cannot be empty.";	
		}

		if ($organization_name != $results["name"]) {
			if (!isOrganizationNameUnique($pdo, $organization_name)) {
				$organization_errors["invalid_organization_name"] = "Organization name (" . $organization_name . ") already exists within the database.";
			}
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($organization_errors) {
		$_SESSION["insert_organization_errors"] = $organization_errors;

		$queryData = [

			"organization_id" => $organization_id,
			"organization_name" => $organization_name,
			"info_cache_id" => $info_cache_id
		];
		$_SESSION["modify_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/organizationMain.php");
		die();
	}

	modifyOrganization($pdo, $organization_id, $organization_name, $info_cache_id);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/organizationMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
