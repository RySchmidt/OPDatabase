<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "chapter/chapterContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/chapterMain.php");
	die();
}

$chapter_number = intval($_POST["chapter_number"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$chapter_errors = [];

	if ($chapter_number <= 0) {
		$chapter_errors["empty_input"] = "Select a chapter to modify.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($chapter_errors) {
		$_SESSION["modify_chapter_errors"] = $chapter_errors;

		header("Location: /OPDatabase/pages/chapterMain.php");
		die();
	}

	$chapter_result = getChapterFromNumber($pdo, $chapter_number);
	$cover_story_result = getCoverStoryFromChapterNumber($pdo, $chapter_number);

	$query_data = [
		"chapter_info_cache_id" => $chapter_result["_chapter_info_cache_id"],
		"chapter_number" => $chapter_result["chapter_number"],
		"chapter_title" => $chapter_result["chapter_title"],
		"chapter_publish_date" => $chapter_result["publish_date"],
		"chapter_volume_number" => $chapter_result["_volume_number"],
		"chapter_story_arc_id" => $chapter_result["_chapter_story_arc_id"],
		"cover_story_info_cache_id" => $cover_story_result["_cover_story_info_cache_id"],
		"cover_story_title" => $cover_story_result["cover_story_title"],
		"cover_story_arc_id" =>$cover_story_result["_cover_story_arc_id"]
	];
	$_SESSION["modify_query_data"] = $query_data;

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/chapterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
