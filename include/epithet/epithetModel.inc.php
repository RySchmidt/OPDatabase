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

function updateEpithet(object $pdo, string $original_epithet, string $epithet, int $character_id, int $info_cache_id) {
	$query = "UPDATE _epithet
		SET _epithet.epithet = :epithet
		WHERE _epithet.epithet = :original_epithet, _epithet.character_id = :character_id, _epithet.info_cache_reveal:info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":original_epithet", $original_epithet);
	$stmt->bindParam(":epithet", $epithet);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

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
		WHERE _epithet.epithet = :epithet;";
	
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":epithet", $epithet);

	$stmt->execute();
}
