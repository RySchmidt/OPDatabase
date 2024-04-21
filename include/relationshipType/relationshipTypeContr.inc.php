<?php
declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "relationshipType/relationshipTypeModel.inc.php";

function addRelationshipType(object $pdo, string $relationship_type_name, int $inverse_relationship_type_id) {
	insertRelationshipType($pdo, $relationship_type_name, $inverse_relationship_type_id);
	$result = selectRelationshipTypeFromName($pdo, $relationship_type_name);
	updateRelationshipTypeInverse($pdo, $inverse_relationship_type_id, $result["id"]);
}

function modifyRelationshipType(object $pdo, int $relationship_type_id, string $relationship_type_name, int $inverse_relationship_type_id) {	
	$result = selectRelationshipTypeFromId($pdo, $relationship_type_id);
	$inverse_relationship_result = selectRelationshipTypeFromId($pdo, $inverse_relationship_type_id);

	if (!empty($result["_relationship_type_inverse"])) {
		updateRelationshipTypeInverse($pdo, $result["_relationship_type_inverse"], 0);
	}

	if (!empty($inverse_relationship_result["_relationship_type_inverse"])) {
		updateRelationshipTypeInverse($pdo, $inverse_relationship_result["_relationship_type_inverse"], 0);
	}

	updateRelationshipType($pdo, $relationship_type_id, $relationship_type_name, $inverse_relationship_type_id);
	updateRelationshipTypeInverse($pdo, $inverse_relationship_type_id, $relationship_type_id);
}

function removeRelationshipType(object $pdo, int $relationship_type_id) {		
	deleteRelationshipType($pdo, $relationship_type_id);
}

function isRelationshipTypeInverseUnique(object $pdo, int $relationship_type_id_inverse) {
	if (selectRelationshipTypeFromInverseId($pdo, $relationship_type_id_inverse)) {
		return false;
	}
	return true;
}	

function isRelationshipTypeNameUnique(object $pdo, string $relationship_type_name) {
	if (selectRelationshipTypeFromName($pdo, $relationship_type_name)) {
		return false;
	}
	return true;
}	

function doesRelationshipTypeHaveInverse(object $pdo, int $relationship_type_id) {
	return selectRelationshipInverseFromId($pdo, $relationship_type_id);
}	

function getRelationshipTypeFromId(object $pdo, int $relationship_type_id) {
	return selectRelationshipTypeFromId($pdo, $relationship_type_id);
}

function getAllRelationshipType(object $pdo) {
	selectRelationshipType($pdo);
}

function getAdvancedRelationshipType(object $pdo) {
	return selectAdvancedRelationshipType($pdo);
}

