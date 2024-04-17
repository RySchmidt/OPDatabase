<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function selectStoryArc(object $pdo) {
	$query = "SELECT *
		FROM _story_arc;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectAdvancedStoryArc(object $pdo) {
	updateAdvancedStoryArc($pdo);
	$query = "SELECT *
		FROM _advanced_story_arc
		ORDER BY min_chapter ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function updateAdvancedStoryArc(object $pdo) {

	$query = "CREATE OR REPLACE VIEW _advanced_story_arc AS
		SELECT T3.id AS story_arc_id, T3.title AS story_arc_title, T3._story_arc_parent as _parent_story_arc, _story_arc.title AS _parent_story_arc_title, MIN(T3.min_chapter) AS min_chapter, MAX(T3.max_chapter) AS max_chapter
		FROM (SELECT _story_arc.*, min_chapter, max_chapter
		FROM _story_arc
		LEFT JOIN (SELECT _chapter._story_arc_id, MIN(_chapter.number) AS min_chapter, MAX(_chapter.number) AS max_chapter 
		FROM _chapter
		GROUP BY _chapter._story_arc_id) AS T1
		ON _story_arc.id = T1._story_arc_id
UNION
SELECT _story_arc.*, MIN(T2.min_chapter) AS min_chapter, MAX(T2.max_chapter) AS max_chapter
FROM _story_arc
LEFT JOIN (SELECT _chapter._story_arc_id, MIN(_chapter.number) AS min_chapter, MAX(_chapter.number) AS max_chapter 
FROM _chapter
GROUP BY _chapter._story_arc_id) AS T2
ON _story_arc.id = T2._story_arc_id
GROUP BY _story_arc._story_arc_parent || _story_arc.id) AS T3
LEFT JOIN _story_arc 
ON _story_arc.id = T3._story_arc_parent
GROUP BY T3.id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}
