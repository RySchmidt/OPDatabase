<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "character/characterContr.inc.php";
require_once "occupation/occupationContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/characterMain.php");
	die();
}

$info_cache_id_reveal = intval($_POST["info_cache_id_reveal"]);
$original_occupation = intval($_POST["original_occupation"]);
$original_info_cache = intval($_POST["original_info_cache"]);
$character_id = intval($_POST["character_id"]);
$info_cache_reveal = intval($_POST["info_cache_reveal"]);
$character_occupation = intval($_POST["character_occupation"]);

$character_organization = intval($_POST["character_organization"]);
$original_organization = intval($_POST["original_organization"]);

$original_info_cache_invalid = intval($_POST["original_info_cache_invalid"]);
$info_cache_invalid = intval($_POST["info_cache_invalid"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$character_errors = [];

	if ($character_id <= 0) {	
		$character_errors["no_selection"] = "Select a character to add information to";	
	}
	else {
		if ($character_occupation <= 0
			|| $character_organization <= 0
			|| $info_cache_reveal <= 0) {	
			$character_errors["empty_input"] = "Required field (Name, Introduced In) cannot be empty";	
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($character_errors) {
		$_SESSION["modify_character_errors"] = $character_errors;

		$result = getCharacterFromId($pdo, $character_id);

		$queryData = [	
			"info_cache_id_reveal" => $info_cache_id_reveal,
			"min_info_cache_id" => $result["_info_cache_introduced"],
			"info_type" => 3,
			"character_occupation" => $original_occupation,
			"character_organization" => $original_organization,
			"character_id" => $character_id,
			"info_cache_reveal" => $original_info_cache,
			"info_cache_invalid" => $original_info_invalid
		];
		$_SESSION["modify_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}

	modifyOccupation($pdo, $original_occupation, $character_id, $original_organization, $original_info_cache, $character_occupation, $character_id, $character_organization, $info_cache_reveal, $info_cache_invalid);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/characterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
