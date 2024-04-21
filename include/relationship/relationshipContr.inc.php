<?php
declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "relationship/relationshipModel.inc.php";

function addRelationship(object $pdo, int $relationship_type_id, int $character_id_a, int $character_id_b, int $info_cache_reveal, int $info_cache_invalid) {
	insertRelationship($pdo, $relationship_type_id, $character_id_a, $character_id_b, $info_cache_reveal, $info_cache_invalid);
}

function modifyRelationship(object $pdo, int $original_relationship_type_id, int $original_character_id_a, int $original_character_id_b, int $original_info_cache_reveal, int $relationship_type_id, int $character_id, int $character_id_b, int $info_cache_reveal, int $info_cache_invalid) {
	updateRelationship($pdo, $original_relationship_type_id, $original_character_id, $original_character_id_b, $original_info_cache_reveal, $relationship_type_id, $character_id_a, $character_id_b, $info_cache_reveal, $info_cache_invalid);
}

function removeRelationship(object $pdo, int $relationship_type_id, int $character_id_a, int $character_id_b, int $info_cache_reveal) {		
	deleteRelationship($pdo, $relationship_type_id, $character_id_a, $character_id_b, $info_cache_reveal);
}

function isUniqueRelationship(object $pdo, int $relationship_type_id, int $character_id_a, int $character_id_b, int $info_cache_reveal, int $info_cache_invalid) {
	if (getRelationship($pdo, $relationship_type_id, $character_id_a, $character_id_b, $info_cache_reveal)) {
		return true;
	}
	return false;	
}

function getAllRelationship(object $pdo) {
	return selectAllRelationship($pdo);
}

function getRelationshipFromCharacterId(object $pdo, int $character_id_a) {
	return selectRelationshipFromCharacterId($pdo, $character_id_a);
}

function getRelationshipDisplayFromCharacterId(object $pdo, int $character_id) {
	return selectAdvancedRelationshipFromCharacterId($pdo, $character_id);
}
