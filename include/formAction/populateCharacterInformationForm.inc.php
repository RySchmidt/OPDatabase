<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "character/characterContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/characterMain.php");
	die();
}

$character_id = intval($_POST["character_id"]);
$info_type = intval($_POST["info_type"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$character_errors = [];

	if ($character_id <= 0) {
		$character_errors["empty_input"] = "Select a character to add information to.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($character_errors) {
		$_SESSION["insert_character_errors"] = $character_errors;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}

		
	$result = getCharacterFromId($pdo, $character_id);

	$query_data = [
		"character_id" => $character_id, 
		"info_type" => $info_type,
		"min_info_cache_id" => $result["_info_cache_introduced"]
	];

	$_SESSION["insert_query_data"] = $query_data;

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/characterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
