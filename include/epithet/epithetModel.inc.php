<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertEpithet(object $pdo, string $epithet, int $character_id, int $info_cache_id) {
	$query = "INSERT
		INTO _epithet (epithet, _info_cache_reveal, _character_id)
		VALUES (:epithet, :info_cache_id, :character_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":epithet", $epithet);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function updateEpithet(object $pdo, string $original_epithet, string $epithet, int $character_id, int $original_info_cache, int $info_cache_id) {
	$query = "UPDATE _epithet
		SET _epithet.epithet = :epithet, _epithet._info_cache_reveal = :info_cache_id
		WHERE _epithet.epithet = :original_epithet AND _epithet._character_id = :character_id AND _epithet._info_cache_reveal = :original_info_cache;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":original_epithet", $original_epithet);
	$stmt->bindParam(":epithet", $epithet);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);	
	$stmt->bindParam(":original_info_cache", $original_info_cache);

	$stmt->execute();
}

function deleteEpithet(object $pdo, string $epithet, int $character_id, int $info_cache_id) {
	$query = "DELETE 
		FROM _epithet
		WHERE _epithet.epithet = :epithet, _epithet.character_id = :character_id, _epithet.info_cache_reveal:info_cache_id;";
	
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":epithet", $epithet);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function selectEpithet(object $pdo, string $epithet, int $character_id, int $info_cache_id) {
	$query = "SELECT *
		FROM _epithet
		WHERE _epithet.epithet = :epithet, _epithet.character_id = :character_id, _epithet.info_cache_reveal:info_cache_id;";
	
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":epithet", $epithet);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function selectEpithetFromCharacterId(object $pdo, int $character_id) {	
	$query = "SELECT *
		FROM _epithet
		WHERE _epithet._character_id = :character_id;";
	
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectAdvancedEpithetFromCharacterId(object $pdo, int $character_id) {
	updateViewAdvancedEpithet($pdo);
	$query = "SELECT *
		FROM _advanced_epithet
		WHERE _advanced_epithet._character_id = :character_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;

}

function updateViewAdvancedEpithet(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _advanced_epithet AS
		SELECT _epithet.*, _info_cache.publish_date 
		FROM _epithet
		INNER JOIN _info_cache
		ON _epithet._info_cache_reveal = _info_cache.id
		ORDER BY _info_cache.publish_date DESC;";
	
	$stmt = $pdo->prepare($query);

	$stmt->execute();
}

