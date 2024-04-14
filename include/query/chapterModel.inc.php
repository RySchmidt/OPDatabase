<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function selectChapterNumber(object $pdo, string $number) {
	$select_query = "SELECT *
		FROM _chapter
		WHERE number = :number";

	$select_stmt = $pdo->prepare($select_query);
	$select_stmt->bindParam(":number", $chapter);

	$select_stmt->execute();
	$select_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
	return $select_results;
}

function selectChapterTitle(object $pdo, string $title) {
	$select_query = "SELECT *
		FROM _chapter
		WHERE title = :title";

	$select_stmt = $pdo->prepare($select_query);
	$select_stmt->bindParam(":title", $title);

	$select_stmt->execute();
	$select_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
	return $select_results;
}
