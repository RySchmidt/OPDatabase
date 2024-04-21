<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertOccupation(object $pdo, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal, int $info_cache_invalid) {
	if ($info_cache_invalid <= 0) {
		$info_cache_invalid = null;
	}

	$query = "INSERT 
		INTO _occupation (_occupation_type_id, _character_id, _organization_id, _info_cache_reveal, _info_cache_invalid) 
		VALUES (:occupation_type_id, :character_id, :organization_id, :info_cache_reveal, :info_cache_invalid);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":occupation_type_id", $occupation_type_id);
	$stmt->bindParam(":character_id", $character_id);
	$stmt->bindParam(":organization_id", $organization_id);
	$stmt->bindParam(":info_cache_reveal", $info_cache_reveal);
	$stmt->bindParam(":info_cache_invalid", $info_cache_invalid);

	$stmt->execute();
}

function updateOccupation(object $pdo, int $original_occupation_type_id, int $original_character_id, int $original_organization_id, int $original_info_cache_reveal, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal, int $info_cache_invalid) {

	$query = "UPDATE _occupation
		SET _occupation._occupation_type_id = :occupation_type_id, _occupation._character_id = :character_id, _occupation._organization_id = :organization_id, _occupation._info_cache_reveal = :info_cache_reveal, _occupation._info_cache_invalid = :info_cache_invalid
		WHERE _occupation._occupation_type_id = :original_occupation_type_id AND _occupation._character_id = :original_character_id AND _occupation._organization_id = :original_organization_id AND _occupation._info_cache_reveal = :original_info_cache_reveal;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":original_occupation_type_id", $original_occupation_type_id);
	$stmt->bindParam(":original_character_id", $original_character_id);
	$stmt->bindParam(":original_organization_id", $original_organization_id);
	$stmt->bindParam(":original_info_cache_reveal", $original_info_cache_reveal);

	$stmt->execute();
}

function deleteOccupation($pdo, $occupation_type_id, $character_id, $organization_id, $info_cache_reveal) {
	$query = "DELETE
		FROM _occupation
		WHERE _occupation._occupation_type_id = :occupation_type_id AND _occupation._character_id = :character_id AND _occupation._organization_id = :organization_id AND _occupation._info_cache_reveal = :info_cache_reveal;";

	$stmt->bindParam(":occupation_type_id", $occupation_type_id);
	$stmt->bindParam(":character_id", $character_id);
	$stmt->bindParam(":organization_id", $organization_id);
	$stmt->bindParam(":info_cache_reveal", $info_cache_reveal);

	$stmt->execute();
}

function selectAdvancedOccupationFromCharacterId(object $pdo, int $character_id) {
	updateViewAdvancedOccupation($pdo);
	$query = "SELECT *
		FROM _advanced_occupation
		WHERE _advanced_occupation._character_id = :character_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}	

function selectOccupation(object $pdo, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal) {	
	$query = "SELECT *
		FROM _occupation
		WHERE _occupation._occupation_type_id = :occupation_type_id AND _occupation._character_id = :character_id AND _occupation._organization_id = :organization_id AND _occupation._info_cache_reveal = :info_cache_reveal;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":occupation_type_id", $occupation_type_id);
	$stmt->bindParam(":character_id", $character_id);
	$stmt->bindParam(":organization_id", $organization_id);
	$stmt->bindParam(":info_cache_reveal", $info_cache_reveal);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function updateViewAdvancedOccupation(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _advanced_occupation AS
		SELECT T1.occupation_name, T1._occupation_type_id, T1._character_id, _organization.name AS organization_name, T1._organization_id, T1._info_cache_reveal, T1._info_cache_invalid
		FROM (SELECT _occupation_type.name AS occupation_name, _occupation.*
		FROM _occupation
		INNER JOIN _occupation_type
		ON _occupation._occupation_type_id = _occupation_type.id) AS T1
		INNER JOIN _organization
		ON _organization.id = T1._organization_id;";
	$stmt = $pdo->prepare($query);

	$stmt->execute();
} 
