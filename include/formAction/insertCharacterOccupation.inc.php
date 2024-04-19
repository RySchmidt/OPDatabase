<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "infoCache/infoCacheContr.inc.php";
require_once "occupation/occupationContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/characterMain.php");
	die();
}

$character_id = intval($_POST["character_id"]);

$character_occupation = intval($_POST["character_occupation"]);
$character_organization = intval($_POST["character_organization"]);

$info_cache_reveal = intval($_POST["info_cache_reveal"]);
$info_cache_invalid = intval($_POST["info_cache_invalid"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$character_errors = [];

	if ($character_id <= 0) {	
		$character_errors["no_selection"] = "Select a character to add information to";	
	}
	else {
		if ($info_cache_reveal <= 0
			|| $character_occupation <= 0
			|| $character_organization <= 0 ) {	
			$character_errors["empty_input"] = "Fill in required field (Epithet, Introduced In)";	
		}
		else if (!($info_cache_invalid <= 0)){
			$result_reveal = getInfoCacheFromId($pdo, $info_cache_reveal);
			$result_invalid = getInfoCacheFromId($pdo, $info_cache_invalid);
			if ($result_reveal["publish_date"] > $result_reveal["publish_date"]) {
				$character_errors["invalid_dates"] = "The reveal of this occupation must come before the invalidation of this occupation";		
			}
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($character_error) {
		$_SESSION["insert_character_errors"] = $character_errors;

		$queryData = [

			"character_id" => $character_id,

			"character_occupation" => $character_occupation,
			"character_organization" => $character_organization,

			"info_cache_reveal" => $info_cache_reveal,
			"info_cache_invalid" => $info_cache_invalid
		];

		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/characterMain.php");
		die();
	}
	
	addOccupation($pdo, $character_occupation, $character_id, $character_organization, $info_cache_reveal, $info_cache_invalid);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/characterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
