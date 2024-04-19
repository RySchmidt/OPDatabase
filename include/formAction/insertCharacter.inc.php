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

$character_name = $_POST["character_name"];
$character_epithet = $_POST["character_epithet"];
$character_info_cache_id = intval($_POST["info_cache_id"]);

$character_notes = $_POST["character_notes"];

try {

	require_once "dbh.inc.php";

	// ERROR 

	$character_errors = [];

	if (!(empty($character_notes) || empty($character_name) || empty($character_epithet))) {	
		$character_errors["unidentifyable"] = "Include atleast one decerning feature about the character (Name, Epithet, or Notes.)";	
	}

	if ($character_info_cache_id <= 0) {	
		$character_errors["empty_input"] = "Fill in required fireld (Introduced In)";	
	}
	

	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($character_error) {
		$_SESSION["insert_character_errors"] = $character_errors;

		$queryData = [

			"character_name" => $character_name,
			"character_epithet" => $character_epithet,
			"character_info_cache_id" => $character_info_cache_id,	
			"character_notes" => $character_notes = $_POST["character_notes"]
		];
		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}

	$character_id = intval(addCharacter($pdo, $character_info_cache_id, $character_notes));

	if (!empty($character_name)) {
		addName($pdo, $character_name, $character_id, $character_info_cache_id);
	}

	if (!empty($character_epithet)) {
		addEpithet($pdo, $character_epithet, $character_id, $character_info_cache_id);
	}

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/characterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
