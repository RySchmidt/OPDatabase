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
		$chapter_errors["empty_input"] = "Select chapter for deletion.";	
	}

	require_once "configSession.inc.php";

	unset($_SESSION["delete_chapter_data_query"]);

	if ($chapter_errors) {
		$_SESSION["delete_chapter_errors"] = $chapter_errors;

		header("Location: /OPDatabase/pages/chapterMain.php");
		die();
	}

	removeChapter($pdo, $chapter_number);

	$pdo = null;
	$stmt = null;

	header("Location: /OPDatabase/pages/chapterMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
