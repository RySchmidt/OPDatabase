<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function selectAllCoverStories(object $pdo) {
	$query = "SELECT *
		FROM _cover_story
		INNER JOIN _info_cache 
		ON _cover_story._info_cache_id = _info_cache.id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectCoverStoryTitle(object $pdo, string $cover_story_title) {
	$query = "SELECT *
		FROM _cover_story
		INNER JOIN _info_cache 
		ON _cover_story._info_cache_id = _info_cache.id
		WHERE title = :title;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":title", $cover_story_title);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectCoverStoryChapterNumber(object $pdo, int $chapter_number) {
	$query = "SELECT *
		FROM _cover_story
		INNER JOIN _info_cache 
		ON _cover_story._info_cache_id = _info_cache.id	
		WHERE _cover_story._chapter_number = :chapter_number";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":chapter_number", $chapter_number);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}


function deleteCoverStory(object $pdo, int $chapter_number) {	
	$result = selectCoverStoryChapterNumber($pdo, $chapter_number);
	$info_cache_id = $result["_info_cache_id"];

	$query = "DELETE 
		FROM _info_cache
		WHERE _info_cache.id = :info_cache_id;";

	$stmt = $pdo->prepare($query);

	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();
}

function insertCoverStory(object $pdo, int $chapter_number, string $cover_story_title, string $publish_date, int $cover_story_arc_id) {

	if ($cover_story_arc_id <= 0) {
		$cover_story_arc_id = null;	
	}

	$query = "INSERT 
		INTO _info_cache (publish_date) 
		VALUES (:publish_date);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":publish_date", $publish_date);

	$stmt->execute();

	$info_cache_id = $pdo->lastInsertId("id");

	$query = "INSERT 
		INTO _cover_story (title, _info_cache_id, _chapter_number, _story_arc_id) 
		VALUES (:cover_story_title, :info_cache_id, :chapter_number, :story_arc_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":cover_story_title", $cover_story_title);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":chapter_number", $chapter_number);
	$stmt->bindParam(":story_arc_id", $cover_story_arc_id);

	$stmt->execute();
}

function updateCoverStory(object $pdo, int $chapter_number, string $cover_story_title, int $cover_story_arc_id, string $publish_date) {
	if ($cover_story_arc_id <= 0) {
		$story_arc_id = null;	
	}

	$result = selectCoverStoryChapterNumber($pdo, $chapter_number);
	$cover_story_info_cache_id = $result["_info_cache_id"];

	$query = "UPDATE _info_cache
		SET _info_cache.publish_date = :publish_date
		WHERE _info_cache.id = :cover_story_info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":info_cache_id", $cover_story_info_cache_id);

	$stmt->execute();

	$query = "UPDATE _cover_story
		SET _cover_story.title = :cover_story_title, _cover_story._story_arc_id = :cover_story_arc_id;
	WHERE cover_story.id = :cover_story_info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":cover_story_title", $cover_story_title);
	$stmt->bindParam(":cover_story_arc_id", $cover_story_arc_id);
	$stmt->bindParam(":info_cache_id", $cover_story_info_cache_id);

	$stmt->execute();

}


function updateViewInfoCacheCoverStory(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _info_cache_cover_story AS
		SELECT _cover_story._info_cache_id AS _cover_story_info_cache_id, _info_cache.publish_date, _cover_story._chapter_number, _cover_story.title AS cover_story_title, _cover_story._story_arc_id AS _cover_story_arc_id
		FROM _info_cache
		INNER JOIN _cover_story
		ON _info_cache.id = _cover_story._info_cache_id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}
