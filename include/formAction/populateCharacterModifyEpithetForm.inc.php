<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "character/characterContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/characterMain.php");
	die();
}

$character_id = intval($_POST["character_id"]);
$info_cache_id_reveal = intval($_POST["info_cache_id_reveal"]);

$parse_results = [];
parse_str($_POST["character_epithet"], $parse_results);

$epithet = $parse_results["epithet"];
$info_cache_reveal = $parse_results["info_cache_reveal"];

try {

	require_once "dbh.inc.php";

	// ERROR 

	$character_errors = [];

	if ($character_id <= 0) {
		$character_errors["empty_input"] = "Select a character to modify the information of.";	
	}

	if (empty($epithet)) {
		$character_errors["no_epithet"] = "Select a epithet to modify.";
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($character_errors) {
		$_SESSION["modify_character_errors"] = $character_errors;

		$queryData = [
			"info_cache_id_reveal" => $info_cache_id_reveal,
			"character_id" => $character_id,
			"info_type" => 2
		];
	
		$_SESSION["modify_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}

	$result = getCharacterFromId($pdo, $character_id);

	$query_data = [
		"info_cache_id_reveal" => $info_cache_id_reveal,
		"info_cache_reveal" => $info_cache_reveal,
		"character_id" => $character_id, 
		"character_epithet" => $epithet, 
		"min_info_cache_id" => $result["_info_cache_introduced"],
		"info_type" => 2
	];
	$_SESSION["modify_query_data"] = $query_data;

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/characterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
