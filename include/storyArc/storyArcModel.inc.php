<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertStoryArc(object $pdo, string $story_arc_title, int $parent_story_arc_id) {
	if ($parent_story_arc_id <= 0) {
		$parent_story_arc_id = null;
	}
	$query = "INSERT 
		INTO _story_arc (title, _story_arc_parent) 
		VALUES (:story_arc_title, :parent_story_arc_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":story_arc_title", $story_arc_title);	
	$stmt->bindParam(":parent_story_arc_id", $parent_story_arc_id);	

	$stmt->execute();
}

function updateStoryArc(object $pdo, int $story_arc_id, string $story_arc_title, int $parent_story_arc_id) {
	if ($parent_story_arc_id <= 0) {
		$parent_story_arc_id = null;
	}

	$query = "UPDATE _story_arc
		SET _story_arc.title = :story_arc_title, _story_arc._story_arc_parent = :parent_story_arc_id
		WHERE _story_arc.id = :story_arc_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":story_arc_id", $story_arc_id);	
	$stmt->bindParam(":story_arc_title", $story_arc_title);	
	$stmt->bindParam(":parent_story_arc_id", $parent_story_arc_id);	

	$stmt->execute();
}

function deleteStoryArc(object $pdo, int $story_arc_id) {
	$query = "DELETE 
		FROM _story_arc
		WHERE _story_arc.id = :story_arc_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":story_arc_id", $story_arc_id);

	$stmt->execute();
}

function selectStoryArc(object $pdo) {
	$query = "SELECT *
		FROM _story_arc
		ORDER BY title ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectStoryArcFromTitle(object $pdo, string $story_arc_title) {
	$query = "SELECT *
		FROM _story_arc
		WHERE _story_arc.title = :story_arc_title;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":story_arc_title", $story_arc_title);	

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectAdvancedStoryArc(object $pdo) {
	updateAdvancedStoryArc($pdo);
	$query = "SELECT*
		FROM _advanced_story_arc
		ORDER BY -min_chapter DESC, story_arc_title ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectAdvancedStoryArcFromId(object $pdo, int $story_arc_id) {
	updateAdvancedStoryArc($pdo);
	$query = "SELECT *
		FROM _advanced_story_arc
		WHERE _advanced_story_arc.story_arc_id = :story_arc_id";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":story_arc_id", $story_arc_id);	

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function updateAdvancedStoryArc(object $pdo) {

	$query = "CREATE OR REPLACE VIEW _advanced_story_arc AS
SELECT T3.*, MIN(T7.min_chapter) AS min_chapter, MAX(T7.max_chapter) AS max_chapter
		FROM (SELECT T1.id AS story_arc_id, T1.title AS story_arc_title, T2.id AS parent_arc_id, T2.title AS parent_arc_title
		FROM _story_arc AS T1
		LEFT JOIN _story_arc AS T2
		ON T1._story_arc_parent = T2.id) AS T3
		LEFT JOIN (SELECT _story_arc.id, min_chapter, max_chapter
		FROM _story_arc
		INNER JOIN
		(SELECT _story_arc.*, min_chapter, max_chapter
		FROM _story_arc
		LEFT JOIN (SELECT _chapter._story_arc_id, MIN(_chapter.number) AS min_chapter, MAX(_chapter.number) AS max_chapter 
		FROM _chapter
		GROUP BY _chapter._story_arc_id) AS T4
		ON _story_arc.id = T4._story_arc_id) AS T5
		ON _story_arc.id = T5._story_arc_parent
UNION
SELECT _story_arc.id, min_chapter, max_chapter
FROM _story_arc
LEFT JOIN (SELECT _chapter._story_arc_id, MIN(_chapter.number) AS min_chapter, MAX(_chapter.number) AS max_chapter 
FROM _chapter
GROUP BY _chapter._story_arc_id) AS T6
ON _story_arc.id = T6._story_arc_id) AS T7
ON T3.story_arc_id = T7.id
GROUP BY T3.story_arc_id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}
