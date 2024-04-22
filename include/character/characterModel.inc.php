<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertCharacter(object $pdo, int $info_cache_id, string $notes) {
	$query = "INSERT
		INTO _character (_info_cache_introduced, notes)
		VALUES (:info_cache_id, :notes);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":notes", $notes);

	$stmt->execute();

	$character_id = $pdo->lastInsertId("id");
	return $character_id;
}

function updateCharacter(object $pdo, int $character_id, int $info_cache_id, string $notes) {
	$query = "UPDATE _character
		SET _character._info_cache_introduced = :info_cache_id, _character.notes = :notes
		WHERE _character.id = :character_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":notes", $notes);

	$stmt->execute();
}

function deleteCharacter(object $pdo, int $character_id) {	
	$query = "DELETE 
		FROM _character
		WHERE _character.id = :character_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function selectCharacterSelection(object $pdo) {  
	$query = "SELECT T1.*, _epithet.epithet
		FROM (SELECT _character.id, _character.notes, _name.name
		FROM _character
		LEFT JOIN _name
		ON _character.id = _name._character_id) AS T1
		LEFT JOIN _epithet
		ON _character_id = _epithet._character_id
		GROUP BY T1.id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}
function selectCharacterFromId(object $pdo, int $character_id) {
	$query = "SELECT *
		FROM _character
		WHERE _character.id = :character_id
		ORDER BY _character.id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}
