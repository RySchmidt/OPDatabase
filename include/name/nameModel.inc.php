<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertName(object $pdo, string $name, int $character_id, int $info_cache_id) {
	$query = "INSERT
		INTO _name (name, _info_cache_reveal, _character_id)
		VALUES (:name, :info_cache_id, :character_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":name", $name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function updateName(object $pdo, string $original_name, string $name, int $character_id, int $info_cache_id) {
	$query = "UPDATE _name
		SET _name.name = :name
		WHERE _name.name = :original_name, _name.character_id = :character_id, _name.info_cache_reveal:info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":original_name", $original_name);
	$stmt->bindParam(":name", $name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function deleteName(object $pdo, string $name, int $character_id, int $info_cache_id) {
	$query = "DELETE 
		FROM _name
		WHERE _name.name = :name, _name.character_id = :character_id, _name.info_cache_reveal:info_cache_id;";
	
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":name", $name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function selectName(object $pdo, string $name, int $character_id, int $info_cache_id) {
	$query = "SELECT *
		FROM _name
		WHERE _name.name = :name, _name.character_id = :character_id, _name.info_cache_reveal:info_cache_id;";
	
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":name", $name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function selectNameFromCharacterId(object $pdo, int $character_id) {	
	$query = "SELECT *
		FROM _name
		WHERE _name.name = :name;";
	
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":name", $name);

	$stmt->execute();
}
