<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertRelationshipType(object $pdo, string $relationship_type_name, int $inverse_relationship_type_id) {
	if ($inverse_relationship_type_id <= 0) {
		$inverse_relationship_type_id = null;
	}

	$query = "INSERT 
		INTO _relationship_type (name, _relationship_type_inverse) 
		VALUES (:relationship_type_name, :inverse_relationship_type_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":relationship_type_name", $relationship_type_name);
	$stmt->bindParam(":inverse_relationship_type_id", $inverse_relationship_type_id);

	$stmt->execute();
}

function updateRelationshipType(object $pdo, int $relationship_type_id, string $relationship_type_name, int $inverse_relationship_type_id) {
	if ($inverse_relationship_type_id <= 0) {
		$inverse_relationship_type_id = null;
	}

	$query = "UPDATE _relationship_type
		SET _relationship_type.name = :relationship_type_name, _relationship_type._relationship_type_inverse = :inverse_relationship_type_id
		WHERE _relationship_type.id = :relationship_type_id;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":relationship_type_id", $relationship_type_id);
	$stmt->bindParam(":relationship_type_name", $relationship_type_name);
	$stmt->bindParam(":inverse_relationship_type_id", $inverse_relationship_type_id);

	$stmt->execute();
}

function deleteRelationshipType(object $pdo, int $relationship_type_id) {

	$query = "DELETE
		FROM _relationship_type 
		WHERE _relationship_type.id = :relationship_type_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":relationship_type_id", $relationship_type_id);

	$stmt->execute();
}

function selectRelationshipTypeFromId(object $pdo, int $relationship_type_id) {
	$query = "SELECT *
		FROM _relationship_type 
		WHERE _relationship_type.id = :relationship_type_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":relationship_type_id", $relationship_type_id);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectRelationshipTypeFromInverseId(object $pdo, int $inverse_relationship_type) {
	$query = "SELECT *
		FROM _relationship_type 
		WHERE _relationship_type._relationship_type_inverse = :inverse_relationship_type;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":inverse_relationship_type", $inverse_relationship_type);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectRelationshipTypeFromName(object $pdo, string $relationship_type_name) {
	$query = "SELECT *
		FROM _relationship_type
		WHERE _relationship_type.name = :relationship_type_name;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":relationship_type_name", $relationship_type_name);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}	

function selectRelationshipType(object $pdo) {
	$query = "SELECT *
		FROM _relationship_type
		ORDER BY _relationship_type.name ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectAdvancedRelationshipType(object $pdo) {
	updateAdvancedRelationshipType($pdo);

	$query = "SELECT *
		FROM _advanced_relationship_type
		ORDER BY _advanced_relationship_type.relationship_type_name ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectRelationshipInverseFromId($pdo, $relationship_type_id) {
	updateAdvancedRelationshipType($pdo);

	$query = "SELECT *
		FROM _relationship_type
		WHERE _relationship_type._relationship_type_inverse = :relationship_type_id;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function updateAdvancedRelationshipType(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _advanced_relationship_type AS 
		SELECT T1.id AS relationship_type_id, T1.name AS relationship_type_name, T2.name AS inverse_relationship_name
		FROM _relationship_type AS T1
		LEFT JOIN _relationship_type AS T2
		ON T1._relationship_type_inverse = T2.id;";
	
	$stmt = $pdo->prepare($query);

	$stmt->execute();
}

function updateRelationshipTypeInverse(object $pdo, int $relationship_type_id, int $inverse_relationship_type_id) {	
	if ($inverse_relationship_type_id <= 0) {
		$inverse_relationship_type_id = null;
	}

	$query = "UPDATE _relationship_type
		SET _relationship_type._relationship_type_inverse = :inverse_relationship_type_id
		WHERE _relationship_type.id = :relationship_type_id;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":relationship_type_id", $relationship_type_id);
	$stmt->bindParam(":inverse_relationship_type_id", $inverse_relationship_type_id);

	$stmt->execute();
}
