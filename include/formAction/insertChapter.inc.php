<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "chapter/chapterContr.inc.php";
require_once "coverStory/coverStoryContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/chapterMain.php");
	die();
}

$chapter_number = intval($_POST["chapter_number"]);
$chapter_title = $_POST["chapter_title"];
$chapter_publish_date = $_POST["chapter_publish_date"];

$chapter_volume_number = intval($_POST["chapter_volume_number"]);
$chapter_story_arc_id = intval($_POST["chapter_story_arc_id"]);

$cover_story_title = $_POST["cover_story_title"];

$cover_story_arc_id = intval($_POST["cover_story_arc_id"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$chapter_errors = [];
	$cover_story_errors = [];

	if ($chapter_number <= 0
		|| empty($chapter_title)
		|| empty($chapter_publish_date)) {
		$chapter_errors["empty_input"] = "Fill in required fields (Chapter Number, Chapter Title and Publish Date).";	
	}
	if (!isChapterNumberUnique($pdo, $chapter_number)) {
		$chapter_errors["invalid_chapter_number"] = "Chapter number (" . $chapter_number . ") already exists within the database.";
	}
	if (!isChapterTitleUnique($pdo, $chapter_title)) {
		$chapter_errors["invalid_chapter_title"] = "Chapter title (" . $chapter_title . ") already exists within the database.";
	}
	if (!isCoverStoryEmpty($cover_story_title)) {
		if (!isCoverStoryTitleUnique($pdo, $cover_story_title)) {
			$cover_story_errors["invalid_cover_story_title"] = "Cover story title (" . $cover_story_title . ") already exists within the database.";
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($chapter_errors || $cover_story_errors) {
		$_SESSION["insert_chapter_errors"] = $chapter_errors;
		$_SESSION["insert_cover_story_errors"] = $cover_story_errors;

		$queryData = [
			"chapter_number" => $chapter_number,
			"chapter_title" => $chapter_title,
			"chapter_publish_date" => $chapter_publish_date,
			"chapter_volume_number" => $chapter_volume_number,
			"chapter_story_arc_id" => $chapter_story_arc_id,
			"cover_story_title" => $cover_story_title,
			"cover_story_arc_id" =>$cover_story_arc_id,
		];
		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/chapterMain.php");
		die();
	}

	addChapter($pdo, $chapter_number, $chapter_title, $chapter_publish_date, $chapter_volume_number, $chapter_story_arc_id);

	if (!empty($cover_story_title)) {
		addCoverStory($pdo, $chapter_number, $cover_story_title, $chapter_publish_date, $cover_story_arc_id); 
	}

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/chapterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
