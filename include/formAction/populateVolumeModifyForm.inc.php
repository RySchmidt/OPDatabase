<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "volume/volumeContr.inc.php";
require_once "sbs/sbsContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/volumeMain.php");
	die();
}

$volume_number = intval($_POST["volume_number"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$volume_errors = [];

	if ($volume_number <= 0) {
		$volume_errors["empty_input"] = "Select a volume to modify.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($volume_errors) {
		$_SESSION["modify_volume_errors"] = $volume_errors;

		header("Location: /OPDatabase/pages/volumeMain.php");
		die();
	}

	$volume_result = getAdvancedVolumeFromNumber($pdo, $volume_number);

	$query_data = [
		"volume_number" => $volume_result["volume_number"],
		"volume_title" => $volume_result["volume_title"],
		"volume_publish_date" => $volume_result["publish_date"],
		"min_chapter_number" => $volume_result["min_chapter"],
		"max_chapter_number" => $volume_result["max_chapter"],
		"sbs_number" => $volume_result["sbs_number"],
	];
	
	$_SESSION["modify_query_data"] = $query_data;

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/volumeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
