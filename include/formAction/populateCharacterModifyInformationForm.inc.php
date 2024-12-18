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
		$character_errors["empty_input"] = "Select a character to modify the information of.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($character_errors) {
		$_SESSION["insert_character_errors"] = $character_errors;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}

	$result = getCharacterFromId($pdo, $character_id); 

	$query_data = [
		"info_cache_reveal" => $result["_info_cache_introdcued"],
		"info_cache" => $result["_info_cache_introduced"],
		"info_cache_id_reveal" => $result["_info_cache_introduced"],
		"character_id" => $character_id, 
		"info_type" => $info_type
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
