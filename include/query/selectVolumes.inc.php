<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once 'dbh.inc.php';

try {

	$select_query = "SELECT *
		FROM _volumes;";

	$select_stmt = $pdo->prepare($select_query);
	$select_stmt->execute();

	$query_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

	$select_query = NULL;
	$select_stmt = NULL;
	$pdo = NULL;

} catch (PDOException $e) {
	echo "You should not be here!<br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}
