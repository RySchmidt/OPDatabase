<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {	
	header("Location: /OPDatabase/pages/searchMain.php");
	die();
}

$max_chapter_filter = intval($_POST["max_chapter_filter"]);

try {

	require_once "configSession.inc.php";

	unset($_SESSION["max_chapter_filter"]);
	$_SESSION["max_chapter_filter"] = $max_chapter_filter;

	header("Location: /OPDatabase/pages/searchMain.php");
	die();

} catch (PDOException $e) {
	echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
