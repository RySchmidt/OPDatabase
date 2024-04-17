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
$volume_title = $_POST["volume_title"];
$volume_publish_date = $_POST["volume_publish_date"];
$min_chapter_number = intval($_POST["min_chapter_number"]);
$max_chapter_number = intval($_POST["max_chapter_number"]);
$sbs_number = intval($_POST["sbs_number"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$volume_errors = [];
	$sbs_errors = [];

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

	if (!isVolumeNumberUnique($pdo, $volume_number)) {
		$volume_errors["invalid_volume_number"] = "Volume number (" . $volume_number . ") already exists within the database.";
	}

	if (!isVolumeTitleUnique($pdo, $volume_title)) {
		$volume_errors["invalid_volume_title"] = "Volume title (" . $volume_title . ") already exists within the database.";
	}

	if (!empty($sbs_title)) {
		if (!isSBSNumberUnique($pdo, $sbs_number)) {
			$sbs_errors["invalid_sbs_number"] = "SBS number (" . $sbs_number . ") already exists within the database.";
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($volume_errors || $sbs_errors) {
		$_SESSION["insert_volume_errors"] = $volume_errors;
		$_SESSION["insert_sbs_errors"] = $sbs_errors;

		$queryData = [
			"volume_number" => $volume_number,
			"volume_title" => $volume_title,
			"volume_publish_date" => $volume_publish_date,
			"min_chapter_number" => $min_chapter_number,
			"max_chapter_number" => $max_chapter_number,
			"sbs_number" => $sbs_number
		];
		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/volumeMain.php");
		die();
	}

	addVolume($pdo, $volume_number, $volume_title, $volume_publish_date, $min_chapter_number, $max_chapter_number);

	if (!($sbs_number <= 0)) {
		addSBS($pdo, $sbs_number, $volume_publish_date, $volume_number); 
	}

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/volumeMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
