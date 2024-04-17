<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "storyArc/storyArcContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/storyArcMain.php");
	die();
}

$story_arc_id = intval($_POST["story_arc_id"]);

try {

	require_once "dbh.inc.php";

	// ERROR 

	$story_arc_errors = [];

	if ($story_arc_id <= 0) {
		$story_arc_errors["empty_input"] = "Select a story arc to modify.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["modify_query_data"]);

	if ($story_arc_errors) {
		$_SESSION["modify_story_arc_errors"] = $story_arc_errors;

		header("Location: /OPDatabase/pages/storyArcMain.php");
		die();
	}

	$story_arc_result = getAdvancedStoryArcFromId($pdo, $story_arc_id);

	$query_data = [
		"story_arc_id" => $story_arc_result["story_arc_id"],
		"story_arc_title" => $story_arc_result["story_arc_title"],
		"parent_story_arc_id" => $story_arc_result["_parent_story_arc_id"],
		"min_chapter_number" => $story_arc_result["min_chapter"],
		"max_chapter_number" => $story_arc_result["max_chapter"]
	];

	$_SESSION["modify_query_data"] = $query_data;

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/storyArcMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
