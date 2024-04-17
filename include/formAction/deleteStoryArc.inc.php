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
		$story_arc_errors["empty_input"] = "Select story arc for deletion.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["delete_data_query"]);

	if ($story_arc_errors) {
		$_SESSION["delete_story_arc_errors"] = $story_arc_errors;

		header("Location: /OPDatabase/pages/storyArcMain.php");
		die();
	}

	removeStoryArc($pdo, $story_arc_id);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/storyArcMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
