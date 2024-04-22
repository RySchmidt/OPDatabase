<?php declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

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

function updateName(object $pdo, string $original_name, string $name, int $character_id, int $original_info_cache_id, int $info_cache_id) {
	$query = "UPDATE _name
		SET _name.name = :name, _name._info_cache_reveal = :info_cache_id
		WHERE _name.name = :original_name AND _name._character_id = :character_id AND _name._info_cache_reveal = :original_info_cache_id;";

	echo $query . "<br>";

	echo $original_name . "<br>";
echo $name . "<br>";
echo $info_cache_id . "<br>";
echo $character_id . "<br>";
echo $original_info_cache_id . "<br>";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":original_name", $original_name);
	$stmt->bindParam(":name", $name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);
	$stmt->bindParam(":original_info_cache_id", $original_info_cache_id);

	$stmt->execute();
}

function deleteName(object $pdo, string $name, int $character_id, int $info_cache_id) {
	$query = "DELETE 
		FROM _name
		WHERE _name.name = :name AND _name._character_id = :character_id AND _name._info_cache_reveal = :info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":name", $name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
}

function selectName(object $pdo, string $name, int $character_id, int $info_cache_id) {
	$query = "SELECT *
		FROM _name
		WHERE _name.name = :name AND _name.character_id = :character_id AND _name.info_cache_reveal:info_cache_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":name", $name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();

	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectNameFromCharacterId(object $pdo, int $character_id) {	
	$query = "SELECT *
		FROM _name
		WHERE _name._character_id = :character_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectAdvancedNameFromCharacterId(object $pdo, int $character_id) {
	updateViewAdvancedName($pdo);
	$query = "SELECT *
		FROM _advanced_name
		WHERE _advanced_name._character_id = :character_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;

}

function updateViewAdvancedName(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _advanced_name AS
		SELECT _name.*, _info_cache.publish_date 
		FROM _name
		INNER JOIN _info_cache
		ON _name._info_cache_reveal = _info_cache.id
		ORDER BY _info_cache.publish_date DESC;";
	
	$stmt = $pdo->prepare($query);

	$stmt->execute();
}
