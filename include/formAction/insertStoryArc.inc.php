<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "storyArc/storyArcContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/storyArcMain.php");
	die();
}

$story_arc_title = $_POST["story_arc_title"];
$parent_story_arc_id = intval($_POST["parent_story_arc_id"]);
$min_chapter_number = intval($_POST["min_chapter_number"]);
$max_chapter_number = intval($_POST["max_chapter_number"]);

print_r($_POST);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$story_arc_errors = [];

	if (empty($story_arc_title)) {
		$story_arc_errors["empty_input"] = "Fill in required fields (Story Arc Title).";	
	}

	if ($min_chapter_number <= 0 xor $max_chapter_number <= 0) {
		$story_arc_errors["empty_chapter_range"] = "One of the chapter range values is empty.";
	}

	else if ($min_chapter_number > $max_chapter_number) {
		$story_arc_errors["invalid_chapter_range"] = "Chapter range (" . $min_chapter_number . " to " . $max_chapter_number . ") is invalid. Enter the chapter range in the form of 'min' to 'max'.";
	}

	if (!isStoryArcTitleUnique($pdo, $story_arc_title)) {
		$story_arc_errors["invalid_story_arc_title"] = "Volume title (" . $story_arc_title . ") already exists within the database.";
	}


	require_once "configSession.inc.php";

	unset($_SESSION["insert_query_data"]);

	if ($story_arc_errors) {
		$_SESSION["insert_story_arc_errors"] = $volume_errors;

		$queryData = [
			"story_arc_title" => $story_arc_title,
			"parent_story_arc_id" => $parent_story_arc_id,
			"min_chapter_number" => $min_chapter_number,
			"max_chapter_number" => $max_chapter_number,
		];
		$_SESSION["insert_query_data"] = $queryData;

		header("Location: /OPDatabase/pages/storyArcMain.php");
		die();
	}

	addStoryArc($pdo, $story_arc_title, $parent_story_arc_id, $min_chapter_number, $max_chapter_number);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/storyArcMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
