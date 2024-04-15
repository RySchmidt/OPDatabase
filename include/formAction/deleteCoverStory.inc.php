<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "coverStory/coverStoryContr.inc.php";
require_once "chapter/chapterContr.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {	

	$chapter_number = intval($_POST["chapter_number"]);
	
	try {

		require_once "dbh.inc.php";

		$cover_story_errors = [];

		if (chapterNumberIsEmpty($chapter_number)) {
			$cover_story_errors["empty_input"] = "Select cover story for deletion.";
		}

		require_once "configSession.inc.php";

		if ($cover_story_errors) {
			$_SESSION["cover_story_errors"] = $cover_story_errors;

			header("Location: /OPDatabase/pages/chapterMain.php");
			die();
		}
		removeCoverStory($pdo, $chapter_number);

		$pdo = null;
		$stmt = null;

		header("Location: /OPDatabase/pages/chapterMain.php");
		die();

	} catch (PDOException $e) {
		echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
}

else {
	header("Location: /OPDatabase/pages/chapterMain.php");
	die();
}
