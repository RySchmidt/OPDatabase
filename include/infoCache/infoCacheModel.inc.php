<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function selectAllInfoCacheSelection(object $pdo) {
	updateInfoCacheSelection($pdo);
	$query = "SELECT *
		FROM _info_cache_selection 
		ORDER BY _info_cache_selection.publish_date;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectInfoCacheFromId(object $pdo, int $info_cache_id) {
	updateInfoCacheSelection($pdo);
	
	$query = "SELECT *
		FROM _info_cache_selection 
		WHERE _info_cache_selection.id = :info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectRestrictedInfoCacheSelection($pdo, $min_info_cache_id, $max_info_cache_id) {
	updateInfoCacheSelection($pdo);

	if ($max_info_cache_id <= 0 && $min_info_cache_id <= 0) {
		return selectAllInfoCacheSelection($pdo);	
	}
	else if ($max_info_cache_id <= 0) {

		$query = "SELECT *
			FROM _info_cache_selection 
			WHERE _info_cache_selection.publish_date >= (SELECT _info_cache_selection.publish_date
			FROM _info_cache_selection
			WHERE _info_cache_selection.id = :min_info_cache_id)
			ORDER BY _info_cache_selection.publish_date ASC, _info_cache_selection.selection_title ASC;";

		$stmt = $pdo->prepare($query);	
		$stmt->bindParam(":min_info_cache_id", $min_info_cache_id);
	}
	else if ($min_info_cache_id <= 0) {
		$query = "SELECT *
			FROM _info_cache_selection 
			WHERE _info_cache_selection.publish_date <= (SELECT _info_cache_selection.publish_date
			FROM _info_cache_selection
			WHERE _info_cache_selection.id = :max_info_cache_id)
			ORDER BY _info_cache_selection.publish_date ASC, _info_cache_selection.selection_title ASC;";

		$stmt = $pdo->prepare($query);	
		$stmt->bindParam(":max_info_cache_id", $max_info_cache_id);
	}
	else {
		$query = "SELECT *
			FROM _info_cache_selection 
			WHERE _info_cache_selection.publish_date >= (SELECT _info_cache_selection.publish_date
			FROM _info_cache_selection
			WHERE _info_cache_selection.id = :min_info_cache_id)
			AND _info_cache_selection.publish_date <= (SELECT _info_cache_selection.publish_date
			FROM _info_cache_selection
			WHERE _info_cache_selection.id = :max_info_cache_id)
			ORDER BY _info_cache_selection.publish_date ASC, _info_cache_selection.selection_title ASC;";

		$stmt = $pdo->prepare($query);	
		$stmt->bindParam(":min_info_cache_id", $min_info_cache_id);
		$stmt->bindParam(":max_info_cache_id", $max_info_cache_id);

	}

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}


function updateInfoCacheSelection(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _info_cache_selection AS
		SELECT *
		From (SELECT ('Cover Story') AS selection_type, CONCAT ('Cover Story ', _cover_story._chapter_number, ' - ', _cover_story.title) AS selection_title, _info_cache.* 
		FROM _cover_story
		INNER JOIN _info_cache
		ON _cover_story._info_cache_id = _info_cache.id
UNION
SELECT ('SBS') AS selectionType, CONCAT ('SBS ', _sbs.number) AS selection_title, _info_cache.* 
FROM _sbs 
INNER JOIN _info_cache
ON _sbs._info_cache_id = _info_cache.id
UNION
SELECT ('Chapter') AS selectionType, CONCAT ('Chapter ', _chapter.number, ' - ', _chapter.title) AS selectionTitle, _info_cache.* 
FROM _chapter 
INNER JOIN _info_cache
ON _chapter._info_cache_id = _info_cache.id) AS T1
ORDER BY T1.publish_date ASC, T1.selection_title ASC;"; 

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}

