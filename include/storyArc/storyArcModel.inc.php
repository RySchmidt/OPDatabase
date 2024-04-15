<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function selectStoryArcs(object $pdo) {
	$query = "SELECT *
		FROM _story_arc;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function updateViewStoryArcCombined(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _story_arc_combined AS 
		SELECT T1.id AS story_arc_id, T1.title AS story_arc_title, T1._story_arc_parent, T2.title AS _story_arc_parent_title
		FROM _story_arc AS T1
		INNER JOIN _story_arc AS T2
		ON T1._story_arc_parent = T2.id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}
