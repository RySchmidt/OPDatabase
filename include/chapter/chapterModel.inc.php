<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function selectAllChapters(object $pdo) {
	$query = "SELECT *
		FROM _chapter
		INNER JOIN _info_cache 
		ON _chapter._info_cache_id = _info_cache.id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectAllChaptersData(object $pdo) {
	updateAllChapterData($pdo);

	$query = "SELECT *
		FROM allChapterData;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function updateAllChapterData(object $pdo) {
	$query = "CREATE OR REPLACE VIEW allChapterData AS
		SELECT T3.*, _info_cache.publish_date AS publish_date
		FROM (SELECT T2.*, _story_arc.title AS _cover_story_arc_title
		FROM (SELECT T1.*, _story_arc.title AS _chapter_story_arc_title
		FROM (SELECT _chapter.number AS chapter_number, _chapter.title AS chapter_title, _chapter._info_cache_id AS _chapter_info_cache_id, _chapter._volume_number, _chapter._story_arc_id AS _chapter_story_arc_id, _cover_story.title AS _cover_story_title, _cover_story._story_arc_id AS _cover_story_arc_id 	
		FROM _chapter
		LEFT JOIN _cover_story
		ON _cover_story._chapter_number = _chapter.number) AS T1
		LEFT JOIN _story_arc
		ON T1._chapter_story_arc_id = _story_arc.id) AS T2
		LEFT JOIN _story_arc
		ON T2._cover_story_arc_id = _story_arc.id) AS T3
		INNER JOIN _info_cache
		ON T3._chapter_info_cache_id = _info_cache.id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectChapterNumber(object $pdo, int $chapter_number) {
	$query = "SELECT *
		FROM _chapter
		INNER JOIN _info_cache 
		ON _chapter._info_cache_id = _info_cache.id
		WHERE _chapter.number = :chapter_number;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":chapter_number", $chapter_number);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectChapterTitle(object $pdo, string $chapter_title) {
	$query = "SELECT *
		FROM _chapter
		INNER JOIN _info_cache 
		ON _chapter._info_cache_id = _info_cache.id
		WHERE _chapter.title = :title;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":title", $chapter_title);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectChapterInfoCacheId(object $pdo, string $chapter_info_cache_id) {
	$query = "SELECT *
		FROM _chapter
		INNER JOIN _info_cache 
		ON _chapter._info_cache_id = _info_cache.id
		WHERE _chapter._info_cache_id = :info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":info_cache_id", $chapter_info_cache_id);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function deleteChapter(object $pdo, int $chapter_number) {
	$result = selectChapterNumber($pdo, $chapter_number);

	$query = "DELETE 
		FROM _info_cache
		WHERE _info_cache.id = :info_cache_id;";

	$stmt = $pdo->prepare($query);

	$info_cache_id = $result["_info_cache_id"];
	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();
}

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
