<?php declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

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
	$stmt->bindParam(":info_cache_id", $chapter_info_cache_id);

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
		ON _info_cache.id = _chapter._info_cache_id
		ORDER BY chapter_number ASC;";

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

function selectChapterFromInfoCacheId(object $pdo, int $info_cache_id) {
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

function selectChapterInputDisplay(object $pdo) {
	updateViewInfoCacheChapter($pdo);	
	viewInfoCacheCoverStory($pdo);
	viewAdvancedStoryArc($pdo);

	$query = "SELECT T1.*, T2.cover_story_title, T2._cover_story_arc_id, T2._cover_story_arc_title, T2._cover_story_arc_parent, T2._cover_story_arc_parent_title
		FROM (SELECT _info_cache_chapter.*, _advanced_story_arc.story_arc_id, _advanced_story_arc.story_arc_title, _advanced_story_arc.parent_arc_id, _advanced_story_arc.parent_arc_title FROM _info_cache_chapter
		LEFT JOIN _advanced_story_arc
		ON _info_cache_chapter._chapter_story_arc_id = _advanced_story_arc.story_arc_id) AS T1
		LEFT JOIN 
		(SELECT _info_cache_cover_story.*, _advanced_story_arc.story_arc_title AS _cover_story_arc_title, _advanced_story_arc.parent_arc_id AS _cover_story_arc_parent, _advanced_story_arc.parent_arc_title AS _cover_story_arc_parent_title
		FROM _info_cache_cover_story
		LEFT JOIN _advanced_story_arc
		ON _info_cache_cover_story._cover_story_arc_id = _advanced_story_arc.story_arc_id) AS T2
		ON T1.chapter_number = T2._chapter_number  
		ORDER BY T1.chapter_number ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function clearChapterVolumeNumber($pdo, $volume_number) {	
	$query = "UPDATE _chapter
		SET _chapter._volume_number = NULL
		WHERE _chapter._volume_number = :volume_number";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_number", $volume_number);

	$stmt->execute();
}

function updateChapterVolumeNumber($pdo, $volume_number, $min_chapter_number, $max_chapter_number) {
	$query = "UPDATE _chapter
		SET _chapter._volume_number = :volume_number
		WHERE _chapter.number >= :min_chapter_number AND _chapter.number <= :max_chapter_number";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_number", $volume_number);
	$stmt->bindParam(":min_chapter_number", $min_chapter_number);
	$stmt->bindParam(":max_chapter_number", $max_chapter_number);

	$stmt->execute();
}

function clearChapterStoryArc(object $pdo, int $story_arc_id, int $parent_story_arc_id) {
	if ($parent_story_arc_id <= 0) {
		$parent_story_arc_id = null;	
	}

	$query = "UPDATE _chapter
		SET _chapter._story_arc_id = :parent_story_arc_id
		WHERE _chapter._story_arc_id = :story_arc_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":story_arc_id", $story_arc_id);
	$stmt->bindParam(":parent_story_arc_id", $parent_story_arc_id);

	$stmt->execute();
}

function updateChapterStoryArc(object $pdo, int $story_arc_id, int $parent_story_arc_id, int $min_chapter_number, int $max_chapter_number) {
	if ($parent_story_arc_id <= 0) {
		$parent_story_arc_id = null;	
	}
	$query = "UPDATE _chapter
		SET _chapter._story_arc_id = :story_arc_id
		WHERE _chapter.number >= :min_chapter_number AND _chapter.number <= :max_chapter_number AND _chapter._story_arc_id NOT IN (
		SELECT _story_arc.id
          	FROM _story_arc
         	WHERE _story_arc._story_arc_parent = :parent_story_arc_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":story_arc_id", $story_arc_id);
	$stmt->bindParam(":parent_story_arc_id", $parent_story_arc_id);
	$stmt->bindParam(":min_chapter_number", $min_chapter_number);
	$stmt->bindParam(":max_chapter_number", $max_chapter_number);

	$stmt->execute();
}
