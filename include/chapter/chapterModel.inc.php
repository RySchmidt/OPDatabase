<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertChapter(object $pdo, int $chapter_number, string $chapter_title, string $publish_date, int $volume_number, int $story_arc_id) {

	if ($volume_number <= 0) {
		$volume_number = null;	
	}

	if ($story_arc_id <= 0) {
		$story_arc_id = null;	
	}


	$query = "INSERT 
		INTO _info_cache (publish_date) 
		VALUES (:publish_date);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":publish_date", $publish_date);

	$stmt->execute();

	$info_cache_id = $pdo->lastInsertId("id");

	$query = "INSERT 
		INTO _chapter (number, title, _info_cache_id, _volume_number, _story_arc_id) 
		VALUES (:chapter_number, :title, :info_cache_id, :volume_number, :story_arc_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":chapter_number", $chapter_number);
	$stmt->bindParam(":title", $chapter_title);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":volume_number", $volume_number);
	$stmt->bindParam(":story_arc_id", $story_arc_id);	

	$stmt->execute();
}

function updateChapter(object $pdo, int $chapter_info_cache_id, int $chapter_number, string $chapter_title, string $publish_date, int $volume_number, int $story_arc_id) {
	if ($volume_number <= 0) {
		$volume_number = null;	
	}

	if ($story_arc_id <= 0) {
		$story_arc_id = null;	
	}


	$query = "UPDATE _info_cache
		SET _info_cache.publish_date = :publish_date
		WHERE _info_cache.id = :info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":publish_date", $publish_date);
	$stmt->bindParam(":info_cache_id", $chapter_info_cach_id);

	$stmt->execute();

	$query = "UPDATE _chapter
		SET _chapter.number = :chapter_number, _chapter.title = :chapter_title, _chapter._volume_number = :volume_number, _chapter._story_arc_id = :story_arc_id
		WHERE _chapter._info_cache_id = :chapter_info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":chapter_number", $chapter_number);
	$stmt->bindParam(":chapter_title", $chapter_title);
	$stmt->bindParam(":volume_number", $volume_number);
	$stmt->bindParam(":story_arc_id", $story_arc_id);	
	$stmt->bindParam(":chapter_info_cache_id", $chapter_info_cache_id);

	$stmt->execute();

}

function deleteChapter(object $pdo, int $chapter_number) {
	$result = selectChapterFromNumber($pdo, $chapter_number);
	$info_cache_id = $result["_chapter_info_cache_id"];

	$query = "DELETE 
		FROM _info_cache
		WHERE _info_cache.id = :info_cache_id;";

	$stmt = $pdo->prepare($query);

	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();
}

function selectChapterFromNumber(object $pdo, int $number) {
	updateViewInfoCacheChapter($pdo);
	$query = "SELECT *
		FROM _info_cache_chapter
		WHERE _info_cache_chapter.chapter_number = :number;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":number", $number);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectChapterFromTitle(object $pdo, string $title) {
	updateViewInfoCacheChapter($pdo);
	$query = "SELECT *
		FROM _info_cache_chapter
		WHERE _info_cache_chapter.chapter_title = :title;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":title", $title);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function updateViewInfoCacheChapter(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _info_cache_chapter AS
		SELECT _chapter._info_cache_id AS _chapter_info_cache_id, _info_cache.publish_date, _volume_number, _chapter.number as chapter_number, _chapter.title AS chapter_title, _chapter._story_arc_id AS _chapter_story_arc_id
		FROM _info_cache
		INNER JOIN _chapter
		ON _info_cache.id = _chapter._info_cache_id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}

function selectAllInfoCacheChapters(object $pdo) {
	updateViewInfoCacheChapter($pdo);
	$query = "SELECT *
		FROM _info_cache_chapter;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectChapterFromInfoCacheId(object $pdo, string $info_cache_id) {
	updateViewInfoCacheChapter($pdo);
	$query = "SELECT *
		FROM _info_cache_chapter
		WHERE _info_cache_chapter._chapter_info_cache_id = :info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectAllInfoCacheChaptersCoverStories(object $pdo) {
	updateViewInfoCacheChapter($pdo);	
	viewInfoCacheCoverStory($pdo);
	viewStoryArcCombined($pdo);

	$query = "SELECT T1.*, T2.cover_story_title, T2._cover_story_arc_id, T2._cover_story_arc_title, T2._cover_story_arc_parent, T2._cover_story_arc_parent_title
		FROM (SELECT _info_cache_chapter.*, _story_arc_combined.story_arc_title AS _chapter_story_arc_title, _story_arc_combined._story_arc_parent AS _chapter_story_arc_parent, _story_arc_combined._story_arc_parent_title AS chapter_story_arc_parent_title
		FROM _info_cache_chapter
		LEFT JOIN _story_arc_combined
		ON _info_cache_chapter._chapter_story_arc_id = _story_arc_combined.story_arc_id) AS T1
		LEFT JOIN 
		(SELECT _info_cache_cover_story.*, _story_arc_combined.story_arc_title AS _cover_story_arc_title, _story_arc_combined._story_arc_parent AS _cover_story_arc_parent, _story_arc_combined._story_arc_parent_title AS _cover_story_arc_parent_title
		FROM _info_cache_cover_story
		LEFT JOIN _story_arc_combined
		ON _info_cache_cover_story._cover_story_arc_id = _story_arc_combined.story_arc_id) AS T2
		ON T1.chapter_number = T2._chapter_number;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}
