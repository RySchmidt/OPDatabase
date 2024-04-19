<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "character/characterContr.inc.php";
require_once "epithet/epithetContr.inc.php";
require_once "name/nameContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/characterMain.php");
	die();
}


$info_cache_id = intval($_POST["info_cache_id"]);
$character_id = intval($_POST["character_id"]);

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
			|| $info_cache_id <= 0) {	
			$character_errors["empty_input"] = "Fill in required field (Name, Introduced In)";	
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($character_error) {
		$_SESSION["insert_character_errors"] = $character_errors;

		$queryData = [
			"character_name" => $character_name,
			"character_id" => $character_id,
			"info_cache_id" => $info_cache_id
		];
		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}

	addName($pdo, $character_name, $character_id, $info_cache_id);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/characterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
