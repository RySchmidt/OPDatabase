<?php
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {	
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/OPDatabase/include/dbh.inc.php";

try {

	$display_query = "SELECT *
		FROM _chapter
		INNER JOIN _info_cache ON _chapter._info_cache_id = _info_cache.id";

	$display_stmt = $pdo->prepare($display_query);
	$display_stmt->execute();

	$display_results = $display_stmt->fetchAll(PDO::FETCH_ASSOC);

	$display_query = NULL;
	$display_stmt = NULL;
	$pdo = null;

	header("Location: ../chapter.php");

} catch (PDOException $e) {
	echo "You should not be here!<br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
/*
else {
	header("Location: ../chapter.php");
}
 */
