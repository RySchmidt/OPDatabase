<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertOccupationType(object $pdo, string $occupation_type_name) {
	$query = "INSERT 
		INTO _occupation_type (name) 
		VALUES (:occupation_type_name);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":occupation_type_name", $occupation_type_name);

	$stmt->execute();
}

function updateOccupationType(object $pdo, int $occupation_type_id, string $occupation_type_name) {

	$query = "UPDATE _occupation_type
		SET _occupation_type.name = :occupation_type_name
		WHERE _occupation_type.id = :occupation_type_id;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":occupation_type_id", $occupation_type_id);
	$stmt->bindParam(":occupation_type_name", $occupation_type_name);

	$stmt->execute();
}

function deleteOccupationType(object $pdo, int $occupation_type_id) {

	$query = "DELETE
		FROM _occupation_type 
		WHERE _occupation_type.id = :occupation_type_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":occupation_type_id", $occupation_type_id);

	$stmt->execute();
}

function selectOccupationTypeFromId(object $pdo, int $occupation_type_id) {
	$query = "SELECT *
		FROM _occupation_type 
		WHERE _occupation_type.id = :occupation_type_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":occupation_type_id", $occupation_type_id);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectOccupationTypeFromName(object $pdo, string $occupation_type_name) {
	$query = "SELECT *
		FROM _occupation_type
		WHERE _occupation_type.name = :occupation_type_name;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":occupation_type_name", $occupation_type_name);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}	

function selectOccupationType(object $pdo) {
	$query = "SELECT *
		FROM _occupation_type
		ORDER BY _occupation_type.name ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}
