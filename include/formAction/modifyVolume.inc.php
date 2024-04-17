<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "volume/volumeContr.inc.php";
require_once "sbs/sbsContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/volumeMain.php");
	die();
}

$original_volume_number = intval($_POST["original_volume_number"]);

$volume_number = intval($_POST["volume_number"]);
$volume_title = $_POST["volume_title"];
$volume_publish_date = $_POST["volume_publish_date"];

$min_chapter_number = intval($_POST["min_chapter_number"]);
$max_chapter_number = intval($_POST["max_chapter_number"]);

$sbs_number = intval($_POST["sbs_number"]);

try {

	require_once "dbh.inc.php";

	// ERROR 
	$original_volume = getAdvancedVolumeFromNumber($pdo, $original_volume_number);
	$original_sbs = getSBSFromVolumeNumber($pdo, $original_volume_number);

	$volume_errors = [];
	$sbs_errors = [];

	if ($original_volume_number <= 0) {
		$volume_errors["id_invalid"] = " Select a chapter to modify.";
	}
	else {

		if ($volume_number <= 0
			|| empty($volume_title)
			|| empty($volume_publish_date)) {
			$volume_errors["empty_input"] = "Fill in required fields (Volume Number, Volume Title and Publish Date).";	
		}

		if ($min_chapter_number <= 0 xor $max_chapter_number <= 0) {
			$volume_errors["empty_chapter_range"] = "One of the chapter range values is empty.";

		}

		else if ($min_chapter_number > $max_chapter_number) {
			$volume_errors["ivalid_chapter_range"] = "Chapter range (" . $min_chapter_number . " to " . $max_chapter_number . ") is invalid. Enter the chapter range in the form of 'min' to 'max'.";
		}

		if ($original_volume_number != $volume_number) {
			if (!isVolumeNumberUnique($pdo, $volume_number)) {
				$volume_errors["invalid_volume_number"] = "Volume number (" . $volume_number . ") already exists within the database.";
			}
		}

		if ($original_volume["volume_title"] != $volume_title) {
			if (!isVolumeTitleUnique($pdo, $volume_title)) {
				$volume_errors["invalid_volume_title"] = "Volume title (" . $volume_title . ") already exists within the database.";
			}
		}

		if (!empty($sbs_title) && $original_volume["sbs_number"] != $sbs_number) {
			if (!isSBSNumberUnique($pdo, $sbs_number)) {
				$sbs_errors["invalid_sbs_number"] = "SBS number (" . $sbs_number . ") already exists within the database.";
			}
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($volume_errors || $sbs_errors) {
		$_SESSION["modify_volume_errors"] = $volume_errors;
		$_SESSION["modify_sbs_errors"] = $sbs_errors;

		$query_data = [
			"volume_number" => $original_volume["volume_number"],
			"volume_title" => $original_volume["volume_title"],
			"volume_publish_date" => $original_volume["publish_date"],
			"min_chapter_number" => $original_volume["min_chapter"],
			"max_chapter_number" => $original_volume["max_chapter"],
			"sbs_number" => $original_sbs["sbs_number"],
		];

		$_SESSION["modify_query_data"] = $query_data;

		header("Location: /OPDatabase/pages/volumeMain.php");
		die();
	}

	modifyVolume($pdo, $original_volume_number, $volume_number, $volume_title, $volume_publish_date, $min_chapter_number, $max_chapter_number);

	if (!($original_sbs["sbs_number"] <= 0)) {
		if ($sbs_number <= 0) {
			removeSBS($pdo, $original_sbs["sbs_number"]);
		}
		else {
			modifySBS($pdo, $original_sbs["_sbs_info_cache_id"], $sbs_number, $volume_publish_date);
		}
	}
	else {
		if ($sbs_number != null) {
			addSBS($pdo, $sbs_number, $volume_publish_date, $volume_number);
		}
	}

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/volumeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
