<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertSBS(object $pdo, int $sbs_number, string $publish_date, int $volume_number) {

	$query = "INSERT 
		INTO _info_cache (publish_date) 
		VALUES (:publish_date);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":publish_date", $publish_date);

	$stmt->execute();

	$info_cache_id = $pdo->lastInsertId("id");

	$query = "INSERT 
		INTO _sbs (number, _info_cache_id, _volume_number) 
		VALUES (:sbs_number, :info_cache_id, :volume_number);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":sbs_number", $sbs_number);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":volume_number", $volume_number);

	$stmt->execute();
}


function updateSBS(object $pdo, int $sbs_info_cache_id, int $sbs_number, string $publish_date) {

	$query = "UPDATE _info_cache
		SET _info_cache.publish_date = :publish_date
		WHERE _info_cache.id = :info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":publish_date", $publish_date);
	$stmt->bindParam(":info_cache_id", $sbs_info_cache_id);

	$stmt->execute();

	$query = "UPDATE _sbs
		SET _sbs.number = :sbs_number
		WHERE _sbs._info_cache_id = :sbs_info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":sbs_number", $sbs_number);
	$stmt->bindParam(":sbs_info_cache_id", $sbs_info_cache_id);

	$stmt->execute();

}

function deleteSBS(object $pdo, int $sbs_number) {
	$result = selectSBSFromNumber($pdo, $sbs_number);
	$info_cache_id = $result["_sbs_info_cache_id"];

	$query = "DELETE 
		FROM _info_cache
		WHERE _info_cache.id = :info_cache_id;";

	$stmt = $pdo->prepare($query);

	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();
}

function selectSBSFromNumber(object $pdo, int $sbs_number) {
	updateViewInfoCacheSBS($pdo);
	$query = "SELECT *
		FROM _info_cache_sbs
		WHERE _info_cache_sbs.sbs_number = :sbs_number;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":sbs_number", $sbs_number);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectSBSFromVolumeNumber(object $pdo, int $volume_number) {
	updateViewInfoCacheSBS($pdo);
	$query = "SELECT *
		FROM _info_cache_sbs
		WHERE _info_cache_sbs._volume_number = :volume_number;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_number", $volume_number);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function updateViewInfoCacheSBS(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _info_cache_sbs AS
		SELECT _sbs._info_cache_id AS _sbs_info_cache_id, _info_cache.publish_date, _volume_number, _sbs.number as sbs_number
		FROM _info_cache
		INNER JOIN _sbs
		ON _info_cache.id = _sbs._info_cache_id
		ORDER BY _volume_number ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}

function selectAllInfoCacheSBSs(object $pdo) {
	updateViewInfoCacheSBS($pdo);
	$query = "SELECT *
		FROM _info_cache_sbs;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectSBSFromInfoCacheId(object $pdo, string $info_cache_id) {
	updateViewInfoCacheSBS($pdo);
	$query = "SELECT *
		FROM _info_cache_sbs
		WHERE _info_cache_sbs._chapter_info_cache_id = :info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}
