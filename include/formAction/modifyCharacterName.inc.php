<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "character/characterContr.inc.php";
require_once "name/nameContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/characterMain.php");
	die();
}

$original_name = $_POST["original_name"];
$original_info_cache = intval($_POST["original_info_cache"]);
$character_id = intval($_POST["character_id"]);
$info_cache_reveal = intval($_POST["info_cache_reveal"]);
$character_name = $_POST["character_name"];

try {

	require_once "dbh.inc.php";

	// ERROR 

	$character_errors = [];

	if ($character_id <= 0) {	
		$character_errors["no_selection"] = "Select a character to add information to";	
	}
	else {
		if (empty($character_name) 
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
		
			"min_info_cache_id" => $result["_info_cache_introduced"],
			"info_type" => 1,
			"character_name" => $original_name,
			"character_id" => $character_id,
			"info_cache_reveal" => $original_info_cache
		];
		$_SESSION["modify_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}

	modifyName($pdo, $original_name, $character_name, $character_id, $original_info_cache, $info_cache_reveal);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/characterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
