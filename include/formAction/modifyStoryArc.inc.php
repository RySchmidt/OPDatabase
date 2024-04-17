<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "storyArc/storyArcContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/storyArcMain.php");
	die();
}

$story_arc_id = intval($_POST["story_arc_id"]);
$story_arc_title = $_POST["story_arc_title"];
$parent_story_arc_id = intval($_POST["parent_story_arc_id"]);
$min_chapter_number = intval($_POST["min_chapter_number"]);
$max_chapter_number = intval($_POST["max_chapter_number"]);

try {

	require_once "dbh.inc.php";

	// ERROR 
	$original_story_arc = getAdvancedStoryArcFromId($pdo, $story_arc_id);

	$story_arc_errors = [];

	if ($story_arc_id <= 0) {
		$story_arc_errors["id_invalid"] = " Select a chapter to modify.";
	}
	else {

		if (empty($story_arc_title)) {
			$story_arc_errors["empty_input"] = "Required fields (Story Arc Title) cannot be empty.";	
		}

		if ($min_chapter_number <= 0 xor $max_chapter_number <= 0) {
			$story_arc_errors["empty_chapter_range"] = "One of the chapter range values is empty.";

		}

		else if ($min_chapter_number > $max_chapter_number) {
			$story_arc_errors["ivalid_chapter_range"] = "Chapter range (" . $min_chapter_number . " to " . $max_chapter_number . ") is invalid. Enter the chapter range in the form of 'min' to 'max'.";
		}

		if ($original_story_arc["story_arc_title"] != $story_arc_title) {
			if (!isStoryArcTitleUnique($pdo, $story_arc_title)) {
				$story_arc_errors["invalid_story_arc_title"] = "Story arc title (" . $story_arc_title . ") already exists within the database.";
			}
		}

		if ($original_story_arc["parent_story_arc"] == $story_arc_id) {
			$story_arc_errors["invalid_parent_story_arc"] = "Parent story arc cannot be this arc.";
		}
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($story_arc_errros) {
		$_SESSION["modify_story_arc_errors"] = $story_arc_errors;

		$query_data = [
			"story_arc_id" => $story_arc_id,
			"story_arc_title" => $original_story_arc["story_arc_title"],	
			"parent_story_arc_id" => $original_story_arc["_parent_story_arc"],
			"min_chapter_number" => $original_story_arc["min_chapter"],
			"max_chapter_number" => $original_story_arc["max_chapter"],
		];

		$_SESSION["modify_query_data"] = $query_data;

		header("Location: /OPDatabase/pages/storyArcMain.php");
		die();
	}

	modifyStoryArc($pdo, $story_arc_id, $story_arc_title, $parent_story_arc_id, $min_chapter_number, $max_chapter_number);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/storyArcMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
