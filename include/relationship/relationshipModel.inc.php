<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertRelationship(object $pdo, int $relationship_type_id, int $character_a, int $character_b, int $info_cache_reveal, int $info_cache_invalid) {
	if ($info_cache_invalid <= 0) {
		$info_cache_invalid = null;
	}

	$query = "INSERT 
		INTO _relationship (_relationship_type_id, _character_a, _character_b, _info_cache_reveal, _info_cache_invalid) 
		VALUES (:relationship_type_id, :character_a, :character_b, :info_cache_reveal, :info_cache_invalid);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":relationship_type_id", $relationship_type_id);
	$stmt->bindParam(":character_a", $character_a);
	$stmt->bindParam(":character_b", $character_b);
	$stmt->bindParam(":info_cache_reveal", $info_cache_reveal);
	$stmt->bindParam(":info_cache_invalid", $info_cache_invalid);

	$stmt->execute();
}

function updateRelationship(object $pdo, int $original_relationship_type_id, int $original_character_a, int $original_character_b, int $original_info_cache_reveal, int $relationship_type_id, int $character_a, int $character_b, int $info_cache_reveal, int $info_cache_invalid) {

	$query = "UPDATE _relationship
		SET _relationship._relationship_type_id = :relationship_type_id, _relationship._character_a = :character_a, _relationship._character_b = :character_b, _relationship._info_cache_reveal = :info_cache_reveal, _relationship._info_cache_invalid = :info_cache_invalid
		WHERE _relationship._relationship_type_id = :original_relationship_type_id, _relationship._character_a = :original_character_a, _relationship._character_b = :original_character_b, _relationship._info_cache_reveal = :original_info_cache_reveal;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":original_relationship_type_id", $original_relationship_type_id);
	$stmt->bindParam(":original_character_a", $original_character_a);
	$stmt->bindParam(":original_character_b", $original_character_b);
	$stmt->bindParam(":original_info_cache_reveal", $original_info_cache_reveal);

	$stmt->bindParam(":relationship_type_id", $relationship_type_id);
	$stmt->bindParam(":character_a", $character_a);
	$stmt->bindParam(":character_b", $character_b);
	$stmt->bindParam(":info_cache_reveal", $info_cache_reveal);
	$stmt->bindParam(":info_cache_invalid", $info_cache_invalid);
	$stmt->execute();

}

function deleteRelationship($pdo, $relationship_type_id, $character_a, $character_b, $info_cache_reveal) {
	$query = "DELETE
		FROM _relationship
		WHERE _relationship._relationship_type_id = :relationship_type_id, _relationship._character_a = :character_a, _relationship._character_b = :character_b, _relationship._info_cache_reveal;";

	$stmt->bindParam(":relationship_type_id", $relationship_type_id);
	$stmt->bindParam(":character_a", $character_a);
	$stmt->bindParam(":character_b", $character_b);
	$stmt->bindParam(":info_cache_reveal", $info_cache_reveal);

	$stmt->execute();
}

function selectRelationshipFromCharacterId(object $pdo, string $character_a) {
	$query = "SELECT *
		FROM _relationship
		WHERE _relationship._character_a = :character_a;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character", $character);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}	

function selectRelationship(object $pdo, int $relationship_type_id, int $character_a, int $character_b, int $info_cache_reveal) {	
	$query = "SELECT *
		FROM _relationship
		WHERE _relationship._relationship_type_id = :relationship_type_id, _relationship._character_a = :character_a, _relationship._character_b = :character_b, _relationship._info_cache_reveal = :info_cache_reveal;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":relationship_type_id", $relationship_type_id);
	$stmt->bindParam(":character_a", $character_a);
	$stmt->bindParam(":character_b", $character_b);
	$stmt->bindParam(":info_cache_reveal", $info_cache_reveal);

	$stmt->execute();
}

function selectAdvancedRelationshipFromCharacterId(object $pdo, int $character_id) {
	updateViewAdvancedRelationship($pdo);
	$query = "SELECT *
		FROM _advanced_relationship
		WHERE _advanced_relationship._character_a = :character_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;

}

function updateViewAdvancedRelationship(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _advanced_relationship AS
		SELECT T4.relationship_name, T4._character_a, T4.character_name_a, T4._character_b, T6.name AS character_name_b, T4._info_cache_reveal, T4._info_cache_invalid
		FROM (SELECT T1.relationship_name, T1._character_a, T3.name AS character_name_a, T1._character_b, T1._info_cache_reveal, T1._info_cache_invalid
		FROM (SELECT _relationship_type.name AS relationship_name, _relationship._character_a, _relationship._character_b, _relationship._info_cache_reveal, _relationship._info_cache_invalid
		FROM _relationship 
		INNER JOIN _relationship_type ON _relationship_type.id = _relationship._relationship_type_id) AS T1
INNER JOIN(
	    SELECT
	    *
	    FROM
	    (
		    SELECT
		    _name.*,
		    _info_cache.publish_date
		    FROM
		    _name
		    INNER JOIN _info_cache ON _name._info_cache_reveal = _info_cache.id
		    ORDER BY
		    _info_cache.publish_date
		    DESC
    ) AS T2
    GROUP BY
    T2._character_id
) AS T3
ON
T1._character_a = T3._character_id
) AS T4
INNER JOIN(
	SELECT
	*
	FROM
	(
		SELECT
		_name.*,
		_info_cache.publish_date
		FROM
		_name
		INNER JOIN _info_cache ON _name._info_cache_reveal = _info_cache.id
		ORDER BY
		_info_cache.publish_date
		DESC
    ) AS T5
    GROUP BY
    T5._character_id
) AS T6
ON
T4._character_b = T6._character_id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
} 

